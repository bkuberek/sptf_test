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
  public function tryPremiumAction()
  {
    return $this->render('BKsptfBundle:Default:try.html.twig', array());
  }
  
  /**
   * @Route("/try-premium/success", name="try_premium_success")
   */
  public function tryPremiumSuccessAction()
  {
    return $this->render('BKsptfBundle:Default:try_success.html.twig', array());
  }
  
  /**
   * @Route("/user/validate", name="user_validate")
   */
  public function validateAction()
  {
    $field = $this->get('request')->get('field');
    $value = $this->get('request')->get('value');
    
    $field = substr($field, strlen('user_'));
    
    $response = new Response();
    $response->headers->set('Content-Type', 'application/json');
    
    $user_taken = array('bob', 'jon', 'test', 'tester', 'doe', 'mike', 'paul', 'sam', 'peter', 'don', 'jess', 'tod', 'tom', 'thomas', 'angela');
    $email_taken = array();
    foreach ($user_taken as $username) {
      $email_taken[] = $username.'@gmail.com';
      $email_taken[] = $username.'@yahoo.com';
      $email_taken[] = $username.'@hotmail.com';
      $email_taken[] = $username.'@test.com';
      $email_taken[] = $username.'@'.$username.'.com';
    }
    
    if ($field == 'username') {
      if (in_array(strtolower($value), $user_taken)) {
        $response->setContent(json_encode(array('valid' => false, 'message' => $field.' is already in use.')));
        return $response;
      }
    } elseif ($field == 'email') {
      if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $response->setContent(json_encode(array('valid' => false, 'message' => $field.' is invalid.')));
        return $response;
      } elseif (in_array(strtolower($value), $email_taken)) {
        $response->setContent(json_encode(array('valid' => false, 'message' => $field.' is already in use.')));
        return $response;
      }
    }
    
    $response->setContent(json_encode(array('valid' => true, 'message' => $field.' is valid!')));
    return $response;
  }

}
