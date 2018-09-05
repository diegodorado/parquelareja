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
		'cdh'=>'La Comunidad (para el desarrollo humano)',
		'ph'=>'Partido humanista',
		'ceh'=>'Centro Mundial de Estudios Humanistas',
		'msg'=>'Mundo sin Guerras y sin Violencia',
		'cc'=>'Convergencia de las Culturas'
	);

	$actividades_taller = array(
		'fuego' => 'Producci&oacute;n y Conservaci&oacute;n del Fuego',
		'frio' => 'Trabajos en Fr&iacute;o',
		'metales' => 'Metales',
		'ceramica' => 'Cer&aacute;mica',
		'vidrio' => 'Vidrio',
		'perfumeria' => 'Perfumer&iacute;a'
	);

	$costos = array(
		'cde' => 250,
		'cdt' => 250,
		'taller' => array(
			'con_alojamiento' => array(
				'fuego' => 75,
				'frio'  => 75,
				'ceramica' => 75,
				'metales' => 75,
				'vidrio' => 100,
				'perfumeria' => 75
			),
			'sin_alojamiento' => array(
				'fuego' => 100,
				'frio'  => 100,
				'ceramica' => 100,
				'metales' => 100,
				'vidrio' => 100,
				'perfumeria' => 100
			)
		)
	);


	if (!empty($_POST)){

		
		$data 						= $_POST;
		$data['costos'] 			= $costos;
		$data['organismos'] 		= $organismos;
		$data['actividades_taller'] = $actividades_taller;
		$data['taller_texto']		= "";
		
		if ($data['solicitante'] == 'mensaje'){
			$data['solicitante'] =  'Comunidad del mensaje "'.$comunidad.'"';
		}
		else if ($data['solicitante'] == 'mensaje'){
			$data['solicitante'] =  $organismos[$data['organismo']]. '<br>Equipo "' . $data['equipo_de_base'] . '"';
		}
		$data['solicitante'] = ucfirst($data['solicitante']);
		
		
		$groups = array();
		
		
		if ($data['form-type'] == 'reserva'){
			
			$subject = 'Nueva Reserva de Parques de Estudio y Reflexion La Reja';

			if (isset($_POST['guests'])){
				$secondsInDay		= 60 * 60 * 24;
				$dateFromExploded 	= explode('/',$_POST['fecha_desde']);
				$mktimeForDateFrom 	= mktime(0,0,0,(int)$dateFromExploded[1],(int)$dateFromExploded[0],(int)$dateFromExploded[2]);
				$dateToExploded 	= explode('/',$_POST['fecha_hasta']);
				$mktimeForDateTo 	= mktime(0,0,0,(int)$dateToExploded[1],(int)$dateToExploded[0],(int)$dateToExploded[2]);

				$difference = $mktimeForDateTo - $mktimeForDateFrom;
				$nights		= ($difference / $secondsInDay);
				$days 		= $nights+1;

				$dates = array();
				for ($i=0;$i<$days;$i++){
					$mktimeForCurrentDay = $mktimeForDateFrom + ($secondsInDay * $i);
					$currentDateString = ucfirst($dias[date('w',$mktimeForCurrentDay)]) . ' ' . date('j',$mktimeForCurrentDay) . ' de ' .
					ucfirst($meses[date('n',$mktimeForCurrentDay)-1]) . ' de ' . date('Y',$mktimeForCurrentDay);
					$dates[] = $currentDateString;
				}
				$data['dates'] = $dates;
			}

			$data['costo_total'] = 0;
			$precio_taller = 0;
			if (isset($data['taller'])){
				if (isset($data['guests'])){
					$precio_taller = 75;
				}
				else{
					$precio_taller = 100;
					$data['costo_total'] = $data["taller"]["cantidad"] * $precio_taller;
				}
			}
			
			$data['nights'] = $nights;
			$data['precio_taller'] = $precio_taller;

			if (isset($_POST['taller'])){
				$groups[] = 'reservas_taller';
				$data['taller_texto'] 	= " c/uso de Taller";
				//el costo del taller no esta en funcionamiento aun
			}
			if (isset($_POST['guests']['cde'])){
				$groups[] = 'reservas_cde';
				$data['costo_total'] 		+= count($data['guests']['cde']) * $nights * ($data['costos']['cde']+$precio_taller);
			}
			if (isset($_POST['guests']['cdt'])){
				$groups[] = 'reservas_cdt';
				$data['costo_total'] 		+= count($data['guests']['cdt']) * $nights * ($data['costos']['cdt']+$precio_taller);
			}
			$mail = $this->getPartial('email', $data );

			#
			# Acá se arma el mail que se envía a la persona que hizo la reserva
			#
			$mail_responsable = $this->getPartial('email_responsable', $data );
			$message = Swift_Message::newInstance()
			  ->setFrom(array('reservas@parquelareja.org' => 'Reservas Parque La Reja'))
			  ->setTo($data['email'])
			  ->setSubject("Hemos recibido su pedido de reserva")
			  ->setBody($mail_responsable)
			  ->setContentType("text/html")
			  ->setCharset('utf-8')
			;
			$this->getMailer()->send($message);
			#
			# Acá se envió el mail que se envía a la persona que hizo la reserva	
			#

			
		}
		else if ($data['form-type'] == 'aviso'){

			$subject = 'Nuevo Aviso de uso de la multiuso de Parques de Estudio y Reflexion La Reja';

			$data['actividad'] = substr($data['actividad'],0,36);
			$groups[] = 'reservas_mu';
			$mail = $this->getPartial('email_multiuso', $data );
			
		}






    //busco los mails de los usuarios que estan en los grupos
    //segun el tipo de reserva (cde, cdt, taller)
    $query = Doctrine_Query::create()
      ->select('u.email_address')
      ->from('sfGuardUser u')
      ->leftJoin('u.Groups g')
      ->whereIn('g.name', $groups);

    $emails = array();
    foreach($query->fetchArray() as $user){
		$emails[]=$user['email_address'];
    }


        $message = Swift_Message::newInstance()
          ->setFrom(array('reservas@parquelareja.org' => 'Reservas Parque La Reja'))
          ->setTo($emails)
          ->setSubject($subject)
          ->setBody($mail)
          ->setContentType("text/html")
		  ->setCharset('utf-8')
        ;

		//echo $mail;
		
        $this->getMailer()->send($message);

        $this->redirect('@reserva_sent');
	}
      //$this->getUser()->setFlash('aCacheInvalid', true);


  }

  public function executeSent(sfWebRequest $request)
  {
  }


}
