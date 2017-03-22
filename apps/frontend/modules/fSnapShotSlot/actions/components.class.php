<?php
class fSnapShotSlotComponents extends BaseaSlotComponents
{
  public function executeEditView()
  {
    // Must be at the start of both view components
    $this->setup();
    
    // Careful, don't clobber a form object provided to us with validation errors
    // from an earlier pass
    if (!isset($this->form))
    {
      $this->form = new fSnapShotSlotEditForm($this->id, $this->slot->getArrayValue());
    }
  }
  public function executeNormalView()
  {
    $this->setup();
    $values = $this->slot->getArrayValue();
    $this->url = isset($values['url'])?$values['url']:false;
    $this->title = isset($values['title'])?$values['title']:false;
    $this->text = isset($values['text'])?$values['text']:false;
    $this->align = isset($values['align'])?$values['align']:'left';
    

    // Behave well if it's not set yet!
    if (!count($this->slot->MediaItems))
    {
      $this->itemId = false;
    }
    else
    {
      $i = $this->slot->MediaItems[0];
      $this->itemId = $i->id;
      $this->embed = $i->getEmbedCode(320,200,'c',$i->format,false);
    }    
   
  }
}
