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



    $groups = [];

		$data['costo_total'] = 0;

		if (isset($_POST['taller'])){
      $groups[] = 'reservas_taller';
			$data['taller_texto'] 	= " c/uso de Taller";
		}
		if (isset($_POST['guests']['cde'])){
      $groups[] = 'reservas_cde';
			$data['costo_total'] 		+= count($data['guests']['cde']) * $data['costos']['cde'];
		}
		if (isset($_POST['guests']['cdt'])){
      $groups[] = 'reservas_cdt';
			$data['costo_total'] 		+= count($data['guests']['cdt']) * $data['costos']['cdt'];
		}
		$mail = $this->getPartial('email', $data );




/*
y el aviso de uso de la multiuso??

$groups[] = 'reservas_mu';

*/

    //busco los mails de los usuarios que estan en los grupos
    //segun el tipo de reserva (cde, cdt, taller)
    $query = Doctrine_Query::create()
      ->select('u.email_address')
      ->from('sfGuardUser u')
      ->leftJoin('u.Groups g')
      ->whereIn('g.name', $groups);

    $emails = [];
    foreach($query->fetchArray() as $user){
      $emails[]=$user['email_address'];
    }


        $message = Swift_Message::newInstance()
          ->setFrom(array('reservas@parquelareja.org' => 'Reservas Parque La Reja'))
          ->setTo($emails)
          ->setSubject('Nueva Reserva de Parques de Estudio y Reflexion La Reja')
          ->setBody($mail)
          ->setContentType("text/html")
		  ->setCharset('utf-8')
        ;

        $this->getMailer()->send($message);

        $this->redirect('@reserva_sent');
	}
      //$this->getUser()->setFlash('aCacheInvalid', true);


  }

  public function executeSent(sfWebRequest $request)
  {
  }


}
