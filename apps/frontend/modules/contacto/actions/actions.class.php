<?php

/**
 * contacto actions.
 *
 * @package    symfony
 * @subpackage contacto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactoActions extends aEngineActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new ContactoForm;

    if ($request->isMethod('post'))
    {
//      $this->getUser()->setFlash('aCacheInvalid', true);    
      $this->form->bind($request->getParameter('contacto'));
      if ($this->form->isValid())
      {
        $message = Swift_Message::newInstance()
          ->setFrom(array($this->form->getValue('email') => $this->form->getValue('nombre')))
          ->setTo('info@parquelareja.org')
          ->setSubject('Contacto - Parque La Reja')
          ->setBody($this->form->getValue('comentario'))
          ->setContentType("text/html")
        ;
        $this->getMailer()->send($message);
        
        $this->redirect('@contacto_sent');

      }
    }    
      
      
  }
  public function executeSent(sfWebRequest $request)
  {
  }
  
}
