<?php

class fWidgetFormDate extends sfWidgetFormInput
{

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);    
    $this->addOption('yearRange', '-10:+10');
    $this->addOption('image', false);

  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    //converts database formatted dates only
    if(is_array($value)){
      $value = $value['date'];
    }
    if ($value && !preg_match('~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~', $value, $match)){
      sfContext::getInstance()->getConfiguration()->loadHelpers('Date');
      $value = format_date($value,'dd/MM/yyyy');
    }

    $attributes['class'] = 'a-date-wrapper';
    
    $html = parent::render($name, $value, $attributes, $errors);
    $id = $this->generateId($name, $value);

    $html .= <<<JS
          <script>
	          $(function() {
		          $("#{$id}").datepicker({changeMonth: true,changeYear: true, yearRange:'{$this->getOption('yearRange')}'});
	          });
          </script>
JS;
    return $html;
    
  } 
  
}
