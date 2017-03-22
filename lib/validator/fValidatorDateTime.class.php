<?php

class fValidatorDateTime extends sfValidatorBase
{

  protected function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', '"%value%" is not a valid date.');
  }

  protected function doClean($value)
  {
    //todo: do real validation, not just pass
    $clean = sprintf('%s %02s:%02s',$value['date'],$value['hour'],$value['minute']);
    return $clean;
  }
}
