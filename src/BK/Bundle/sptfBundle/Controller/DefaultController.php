<?php

namespace BK\Bundle\sptfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

  /**
   * @Route("/", name="homepage")
   */
  public function indexAction()
  {
    return $this->render('BKsptfBundle:Default:index.html.twig', array());
  }

}
