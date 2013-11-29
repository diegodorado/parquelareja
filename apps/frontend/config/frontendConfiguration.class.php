<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    //agrego links para administrar el calendario
    $this->dispatcher->connect('a.getGlobalButtons', array('frontendConfiguration', 'getGlobalButtons'));
  }
  
  static public function getGlobalButtons()
  {
    $user = sfContext::getInstance()->getUser();
 
    if ($user->hasCredential('calendario_admin'))
    {
      aTools::addGlobalButtons(array( new aGlobalButton('calendario', 'Calendario', '@calendario_admin_index','a-media')));
    }
  
  }  
  
}
