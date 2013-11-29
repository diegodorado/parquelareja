<?php
class aBlogSlotActions extends BaseaBlogSlotActions
{

  public function executeCalendarEvents(sfWebRequest $request)
  {
    //$this->getResponse()->setContentType('application/json');
    $q = Doctrine_Query::create()
      ->select("p.title, UNIX_TIMESTAMP(p.published_at) as start, CONCAT('aBlog/',p.id) as url")
      ->from('aBlogPost p')
      ->addWhere('p.status= ? ', 'published')
      ->addWhere('UNIX_TIMESTAMP(p.published_at) BETWEEN ? AND ?', array($request->getParameter('start'), $request->getParameter('end')));
    $posts = $q->fetchArray();
	  return $this->renderText( json_encode($posts));
  }
    
 
}
