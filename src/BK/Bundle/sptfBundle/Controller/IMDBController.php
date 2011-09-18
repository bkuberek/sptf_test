<?php

namespace BK\Bundle\sptfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
   * @Route("/imdb/toplist", name="imdb_toplist")
   */
  public function toplistAction()
  {
    
    $em = $this->getDoctrine()->getEntityManager();
    $movies = $this->getDoctrine()
            ->getRepository('BKsptfBundle:Movie')
            ->findAll();
    
    return $this->render('BKsptfBundle:IMDB:toplist.html.twig', array('movies' => $movies));
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
