<?php

namespace BK\Bundle\sptfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

  /**
   * @Route("/", name="homepage")
   */
  public function indexAction()
  {
    return $this->render('BKsptfBundle:Default:index.html.twig', array());
  }
  
  /**
   * @Route("/try-premium", name="try_premium")
   */
  public function tryAction()
  {
    return $this->render('BKsptfBundle:Default:try.html.twig', array());
  }
  
  /**
   * @Route("/user/validate", name="user_validate")
   */
  public function validateAction()
  {
    $field = $this->get('request')->get('field');
    $value = $this->get('request')->get('value');
    
    $result = array('valid' => true);
    
    if ($field == 'user_email') {
      $result['valid'] = false;
      $result['message'] = 'Already taken';
    }
    
    $response = new Response(json_encode($result));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

}
