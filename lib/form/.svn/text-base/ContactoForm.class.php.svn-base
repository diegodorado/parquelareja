<?php

class ContactoForm extends BaseForm
{
  public function configure() {
    $this->disableCSRFProtection();
    $this->setWidgets(array(
      'nombre'    => new sfWidgetFormInputText(),
      'email'     => new sfWidgetFormInputText(),
      'comentario' => new sfWidgetFormTextarea(),
    ));

    $this->widgetSchema->setNameFormat('contacto[%s]');

    $this->setValidators(array(
      'nombre' => new sfValidatorString(array(), array(
                       'required' => __('Olvidaste ingresar tu nombre'))),
      'email'     => new sfValidatorEmail(array(), array(
                       'required' => __('Debes ingresar tu email'),
                       'invalid'  => __('Debes ingresar un email válido'))),
      'comentario' => new sfValidatorString(array(), array(
                       'required' => __('Olvidaste ingresar la consulta'))),
    ));

    $oDecorator = new fWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div');

  }
}
