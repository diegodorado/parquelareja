<?php

/**
 * reserva actions.
 *
 * @package    symfony
 * @subpackage reserva
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reservaActions extends aEngineActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new ReservaForm;  
    $this->titulo = "papapapapapap";

    if ($request->isMethod('post'))
    {
    
    
    
      //$this->getUser()->setFlash('aCacheInvalid', true);    
      $this->form->bind($request->getParameter('reserva'));
      if ($this->form->isValid())
      {

        $datos = $this->form->getValues();
        $datos['fecha_reserva'] = date("d-m-Y H:i");

        $sMail ='';

        switch($datos['ambito']){
          case 'cde':
            $sMail .='<strong>Ambito:</strong> Centro de Estudios<br/><br/>';
            $groups = array('reservas_cde');
            break;
          case 'cdet':
            $sMail .='<strong>Ambito:</strong> Centro de Estudios (con Taller)<br/><br/>';
            $groups = array('reservas_cde', 'reservas_taller');
            break;
          case 'cdt':
            $sMail .='<strong>Ambito:</strong> Centro de Trabajo<br/><br/>';
            $groups = array('reservas_cdt');
            break;
          case 'cdtt':
            $sMail .='<strong>Ambito:</strong> Centro de Trabajo (con Taller)<br/><br/>';
            $groups = array('reservas_cdt', 'reservas_taller');
            break;
          case 'taller':
            $sMail .='<strong>Ambito:</strong> Taller<br/><br/>';
            $groups = array('reservas_taller');
            break;
          case 'mu':
            $sMail .='<strong>Ambito:</strong> Multiuso<br/><br/>';
            $groups = array('reservas_mu');
            break;
        }


        $query = Doctrine_Query::create()
          ->select('u.email_address')
          ->from('sfGuardUser u')
          ->leftJoin('u.Groups g')
          ->whereIn('g.name', $groups);

            
        $emails = array();
        foreach($query->fetchArray() as $user){
          $emails[]=$user['email_address'];
        }

        switch($datos['solicitante']){
          case 'maestro':
            $sMail .='<strong>Maestro:</strong> '.$datos['nombre'].'<br/><br/>';
            break;
          case 'organismo':
            $sMail .='<strong>Organismo:</strong> '.$datos['organismo'].'<br/><br/>';
            break;
          case 'comunidad':
            $sMail .='<strong>Comunidad de el Mensaje de Silo:</strong> '.$datos['comunidad'].'<br/><br/>';
            break;
        }
                
        $sMail .='<strong>Responsable:</strong> '.$datos['responsable'].'<br/><br/>';
        $sMail .='<strong>Telefono:</strong> '.$datos['telefono'].'<br/><br/>';
        $sMail .='<strong>Email:</strong> '.$datos['email'].'<br/><br/>';
        $sMail .='<strong>Comentario:</strong> '.$datos['comentario'].'<br/><br/>';
        $sMail .='<strong>Fecha y Hora de Ingreso:</strong> '.$datos['ingreso'].'<br/><br/>';
        $sMail .='<strong>Fecha y Hora de Egreso:</strong> '.$datos['egreso'].'<br/><br/>';
        $sMail .='<strong>Cantidad de personas:</strong> '.$datos['cantidad_personas'].'<br/><br/>';
        $sMail .='<strong>Fecha y hora de Reserva:</strong> '.$datos['fecha_reserva'].'<br/><br/>';


        $body = $sMail;

        $message = Swift_Message::newInstance()
          ->setFrom(array('reservas@parquelareja.org' => 'Parque La Reja'))
          ->setTo($emails)
          ->setSubject('Nueva Reserva de Parques de Estudio y Reflexion La Reja')
          ->setBody($body)
          ->setContentType("text/html")
        ;
         
        $this->getMailer()->send($message);
        
        $this->redirect('@reserva_sent');
      }
    }    
      
  }

  public function executeSent(sfWebRequest $request)
  {
  }
  
  
}
