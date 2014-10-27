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
    $this->titulo = "papadopulos";
	$this->horario_desde 	= 10;
	$this->horario_hasta	= 22;
	$this->remoteip			= $_SERVER['REMOTE_ADDR'];
	
	$dias = array('domingo','lunes','martes','miercoles','jueves','viernes','s&aacute;bado');
	$meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
	
	$organismos = array(
		'cdh'=>'La comunidad para el desarrollo humano',
		'ph'=>'Partido humanista',
		'ceh'=>'Centro mundial de estudios humanistas',
		'msg'=>'Mundo sin guerras',
		'cc'=>'Convergencia de las culturas'
	);
	
	$actividades_taller = array(
		'fuego' => 'Producci&oacute;n y Conservaci&oacute;n del Fuego',
		'frio' => 'Trabajos en fr&iacute;o',
		'metales' => 'Metales',
		'ceramica' => 'Cer&aacutemica;',
		'vidrio' => 'Vidrio',
		'perfumeria' => 'Perfumer&iacute;a'
	);
	
	$costos = array(
		'cde' => 80,
		'cdt' => 80,
		'taller' => array(
			'con_alojamiento' => array(
				'fuego' => 20,
				'frio'  => 20,
				'ceramica' => 20,
				'metales' => 20,
				'vidrio' => 100,
				'prefumeria' => 20
			),
			'sin_alojamiento' => array(
				'fuego' => 30,
				'frio'  => 30,
				'ceramica' => 30,
				'metales' => 30,
				'vidrio' => 100,
				'prefumeria' => 30
			)
		)
	);
	
	
	if (!empty($_POST)){
	
		$data 						= $_POST;
		$data['costos'] 			= $costos;
		$data['organismos'] 		= $organismos;
		$data['actividades_taller'] = $actividades_taller;
		$data['taller_texto']		= "";
		
		if (isset($_POST['guests'])){
			$secondsInDay		= 60 * 60 * 24;
			$dateFromExploded 	= explode('/',$_POST['fecha_desde']);
			$mktimeForDateFrom 	= mktime(0,0,0,(int)$dateFromExploded[1],(int)$dateFromExploded[0],(int)$dateFromExploded[2]);
			$dateToExploded 	= explode('/',$_POST['fecha_hasta']);
			$mktimeForDateTo 	= mktime(0,0,0,(int)$dateToExploded[1],(int)$dateToExploded[0],(int)$dateToExploded[2]);
			
			$difference = $mktimeForDateTo - $mktimeForDateFrom;
			$days		= ($difference / $secondsInDay) + 1;
			
			$dates = array();
			for ($i=0;$i<$days;$i++){
				$mktimeForCurrentDay = $mktimeForDateFrom + ($secondsInDay * $i);
				$currentDateString = ucfirst($dias[date('w',$mktimeForCurrentDay)]) . ' ' . date('j',$mktimeForCurrentDay) . ' de ' .
				ucfirst($meses[date('n',$mktimeForCurrentDay)-1]) . ' de ' . date('Y',$mktimeForCurrentDay);
				$dates[] = $currentDateString;
			}
			$data['dates'] = $dates;
		}
		
		
		
		$mail_cde 		= "";
		$mail_cdt 		= "";
		$mail_taller	= "";
		$mail_mu		= "";
		
		$data['costo_total'] = 0;
		
		if (isset($_POST['taller'])){
			$data['taller_texto'] 	= " c/uso de Taller";
		}
		if (isset($_POST['guests']['cde'])){
			$data['costo_total'] 		+= count($data['guests']['cde']) * $data['costos']['cde'];
		}
		if (isset($_POST['guests']['cdt'])){
			$data['costo_total'] 		+= count($data['guests']['cdt']) * $data['costos']['cdt'];
		}
		$mail 					= $this->getPartial('email', $data );
		
		$emails 				= "eva@redhumanista.org";
		
		/*die($mail);
		echo '<pre>'; var_dump($_POST); echo '</pre>'; die();
		echo '<pre>'; var_dump($_POST['guests']); echo '</pre>'; die();*/
		
        $message = Swift_Message::newInstance()
          ->setFrom(array('reservas@parquelareja.org' => 'Reservas Parque La Reja'))
          ->setTo($emails)
          ->setSubject('Nueva Reserva de Parques de Estudio y Reflexion La Reja')
          ->setBody($mail)
          ->setContentType("text/html")
        ;
         
        $this->getMailer()->send($message);
        
        $this->redirect('@reserva_sent');
	}

    /*if ($request->isMethod('post'))
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
    }   */
      
  }

  public function executeSent(sfWebRequest $request)
  {
  }
  
  
}
