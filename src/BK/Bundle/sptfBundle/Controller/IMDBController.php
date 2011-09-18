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
    return $this->redirect($this->generateUrl('homepage')); //$this->render('BKsptfBundle:Default:index.html.twig', array());
  }

  /**
   * @Route("/imdb/toplist", name="imdb_toplist")
   */
  public function toplistAction()
  {
    
    return $this->render('BKsptfBundle:IMDB:toplist.html.twig', array());
  }

}
