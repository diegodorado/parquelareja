<?php

class ReservaForm extends BaseForm
{
  public function configure() {
    $this->disableCSRFProtection();
    $ambitos = array('cde' => "Centro de Estudios",
                     'cdet' => "Centro de Estudios (con Taller)",
                     'cdt' => "Centro de Trabajo",
                     'cdtt' => "Centro de Trabajo (con Taller)",
                     'taller' => "Taller",
                     'mu' => 'Multiuso');
    $solicitantes = array(
                      'maestro' => "Maestro",
                      'organismo' => "Organismo",
                      'comunidad' => "El Mensaje de Silo",
                    );
    $organismos = array(
                      "La Comunidad",
                      "Convergencia de las Culturas",
                      "Partido Humanista",
                      "Mundo sin Guerras",
                      "Centro de Estudios Humanistas",
                    );

    $this->setWidgets(array(
      'ambito'    => new sfWidgetFormSelect(array('choices'=>$ambitos)),
      'solicitante'    => new sfWidgetFormSelect(array('choices'=>$solicitantes)),
      'organismo'    => new sfWidgetFormSelect(array('choices'=>$organismos)),
      'comunidad'    => new sfWidgetFormInputText(),
      'nombre'    => new sfWidgetFormInputText(),
      'responsable'    => new sfWidgetFormInputText(),
      'telefono'    => new sfWidgetFormInputText(),
      'email'     => new sfWidgetFormInputText(),
      'ingreso'    => new fWidgetFormDateTime(
			  array('date' => array('image' => '/apostrophePlugin/images/a-icon-datepicker.png')),
			  array('time' => array('twenty-four-hour' => false, 'minutes-increment' => 60))
		  ),
      'egreso'    => new fWidgetFormDateTime(
			  array('date' => array('image' => '/apostrophePlugin/images/a-icon-datepicker.png')),
			  array('time' => array('twenty-four-hour' => false, 'minutes-increment' => 60))
		  ),
      'comentario' => new sfWidgetFormTextarea(),
      'cantidad_personas'    => new sfWidgetFormInputText(),
    ));

    $this->setDefaults(array(
      'ingreso'    => '06:00 PM',
      'egreso'    => '06:00 PM'
    ));



    $this->widgetSchema->setLabels(array(
      'ambito'    => 'Ámbito',
      'solicitante'    => 'Solicitante',
      'organismo'    => 'Organismo',
      'comunidad'    => 'Nombre de la Comunidad',
      'nombre'    => 'Nombre',
      'responsable'    => 'Responsable',
      'telefono'    => 'Telefono',
      'email'     => 'Email',
      'ingreso'    => 'Desde',
      'egreso'    => 'Hasta',
      'comentario' => 'Comentario',
      'cantidad_personas'    => 'Cantidad de personas',
    ));
    
    $this->widgetSchema->setNameFormat('reserva[%s]');
      
    $this->setValidators(array(
      'ambito'    => new sfValidatorString(array('required' => true)),
      'solicitante'    => new sfValidatorString(array('required' => false)),
      'organismo'    => new sfValidatorString(array('required' => false)),
      'comunidad'    => new sfValidatorString(array('required' => false)),
      'nombre'    => new sfValidatorString(array('required' => false)),
      'responsable'    => new sfValidatorString(array('required' => false)),
      'telefono'    => new sfValidatorString(array('required' => false)),
      'email'     => new sfValidatorEmail(array(), array(
                       'required' => __('Debes ingresar tu email'),
                       'invalid'  => __('Debes ingresar un email válido'))),
      'ingreso'    => new fValidatorDateTime(),
      'egreso'    => new fValidatorDateTime(),
//      'ingreso'    => new sfValidatorDateTime(array('required' => true),array(
//                       'required' => __('Debes indicar fecha y hora de ingreso'))),
//      'egreso'    => new sfValidatorDateTime(array('required' => true),array(
//                       'required' => __('Debes indicar fecha y hora de egreso'))),
      'comentario' => new sfValidatorString(array('required' => false)),
      'cantidad_personas'    => new sfValidatorString(array('required' => true),array(
                       'required' => __('Debes indicar la cantidad de personas'))),
    ));

    $oDecorator = new fWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div');

  }
}
