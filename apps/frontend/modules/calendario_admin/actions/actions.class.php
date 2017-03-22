<?php

/**
 * calendario_admin actions.
 *
 * @package    symfony
 * @subpackage calendario_admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class calendario_adminActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->cal = new Calendar;
  }

  public function executeEdit(sfWebRequest $request)
  {

    $this->reserva = new Reserva();
    $this->reserva->fecha = $request->getParameter('fecha');
    //handles form submition
    if ($request->getParameter('save')){
      $this->reserva->id = $request->getParameter('id');
      sfContext::getInstance()->getLogger()->info($request->getParameter('id'));
      $this->reserva->estado_uso_cde = $request->getParameter('estado_uso_cde');
      $this->reserva->estado_uso_cdt = $request->getParameter('estado_uso_cdt');
      $this->reserva->comentario = $request->getParameter('comentario');
      $this->reserva->setTexto($request->getParameter('texto'));
      if ($this->reserva->id){
        $sql="UPDATE reserva SET estado_uso_cde='".$this->reserva->estado_uso_cde."', estado_uso_cdt='".$this->reserva->estado_uso_cdt."', comentario='".($this->reserva->comentario=='on')."', texto='".$this->reserva->getTexto()."' WHERE id=".$this->reserva->id;
      }else{
        $sql="INSERT INTO reserva (fecha, estado_uso_cde, estado_uso_cdt, comentario, texto) VALUES ('".date ("Y-m-d H:i:s", $this->reserva->fecha)."','".$this->reserva->estado_uso_cde."','".$this->reserva->estado_uso_cdt."','".($this->reserva->comentario=='on')."','".$this->reserva->getTexto()."')";
      }
      Doctrine_Manager::getInstance()->getCurrentConnection()->execute($sql);
      $this->redirect('@calendario_admin_index');
    }elseif ($request->getParameter('delete')){
      $this->reserva->id = $request->getParameter('id');
      $sql="DELETE FROM reserva WHERE id=".$this->reserva->id;
      Doctrine_Manager::getInstance()->getCurrentConnection()->execute($sql);
      $this->redirect('@calendario_admin_index');
    }elseif ($request->getParameter('cancel')){
      $this->redirect('@calendario_admin_index');
    }else{
      $sql="select id, fecha, estado_uso_cde, estado_uso_cdt, comentario, texto from reserva where fecha = '".date ("Y-m-d H:i:s", $this->reserva->fecha)."'";
      $rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
      if(isset($rs[0])){
        $row = $rs[0];
        $this->reserva->id = $row['id'];
        $this->reserva->estado_uso_cde = $row['estado_uso_cde'];
        $this->reserva->estado_uso_cdt = $row['estado_uso_cdt'];
        $this->reserva->comentario = $row['comentario'];
        $this->reserva->setTexto($row['texto']);
      }
    }

  }
 
  
}
