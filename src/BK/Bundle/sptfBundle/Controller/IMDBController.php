<?php

namespace BK\Bundle\sptfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IMDBController extends Controller
{

  /**
   * @Route("/imdb", name="imdb")
   */
  public function indexAction()
  {
    return $this->redirect($this->generateUrl('imdb_toplist'));
  }

  /**
   * @Route("/imdb/toplist/{year}", name="imdb_toplist", defaults={"year"=null})
   */
  public function toplistAction($year = null)
  {
    $request = $this->get('request');
    $em = $this->getDoctrine()->getEntityManager();
    $repository = $this->getDoctrine()->getRepository('BKsptfBundle:Movie');
    
    $memcache = $this->get('memcache');
    
    if (!($decades = $memcache->get('sptf/IMDB/decades'))) {
      // Using Doctrine DBAL layer to run a custom query
      $conn = $this->get('database_connection');
      $decades = $conn->fetchAll('SELECT count(`id`) AS `count`, floor(`year`/10)*10 AS `decade` FROM `movie` GROUP BY `decade` ORDER BY `decade` ASC;');

      // little bit of a hack here. I need to add the 's' to identify a decade form a year
      foreach ($decades as $k => $v) {
        $decades[$k]['decade'] = $v['decade'].'s';
      }
      
      // Cache the list of decades until 1 am tomorrow
      // the cron will update the database at midnight and by 3 am should be done 
      $memcache->set('sptf/IMDB/decades', $decades, 0, strtotime('tomorrow') + 3600);
    }
    
    // Using Doctrine's QueryBuilder to generate a DQL query
    $qb = $repository->createQueryBuilder('movie')
            ->orderBy('movie.rating', 'desc')
            ->addOrderBy('movie.votes', 'desc');
    
    $current_decade = null;
    
    if ($year) {
      if (substr($year, -1) == 's' && ($decade = substr($year, 0, 4)) && $decade % 10 == 0) {
        $current_decade = $decade.'s';
        $year = array($decade, $decade+9);
      } else {
        $year = explode('-', $year);
      }
      
      if (count($year) == 1) {
        $qb->where('movie.year = :year');
        $qb->setParameter('year', $year);
      } else {
        $qb->where('movie.year >= :year_start AND movie.year <= :year_end');
        $qb->setParameters(array('year_start' => $year[0], 'year_end' => $year[1]));
      }
    }
    
    $qb->setMaxResults(10);
    
    $q = $qb->getQuery();
    
    $cache_key = 'sptf/IMDB/movies/'.md5($q->getDQL().http_build_query($q->getParameters()).$qb->getMaxResults());
    
    // cache movie results
    if (!($movies = $memcache->get($cache_key))) {
      $movies = $q->getResult();
      $memcache->set($cache_key, $movies, 0, strtotime('tomorrow') + 3600);
    }
    
    return $this->render('BKsptfBundle:IMDB:toplist.html.twig', array(
        'movies' => $movies,
        'decades' => $decades,
        'current_decade' => $current_decade,
        'year_start' => isset($year[0]) ? $year[0] : null,
        'year_end' => isset($year[1]) ? $year[1] : null
    ));
  }
  
  /**
   * @Route("/imdb/movie/{id}", name="imdb_movie")
   */
  public function showAction($id)
  {
    $movie = $this->getDoctrine()
            ->getRepository('BKsptfBundle:Movie')
            ->find($id);

    if (!$movie) {
      throw $this->createNotFoundException('Movie not found');
    }

    return $this->render('BKsptfBundle:IMDB:movie.html.twig', array('movie' => $movie));
  }

}
