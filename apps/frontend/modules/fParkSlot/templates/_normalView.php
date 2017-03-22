<?php use_helper('I18N') ?>
<?php if ($editable): ?>
  <?php slot("a-slot-controls-$pageid-$name-$permid") ?>
  	<li class="a-controls-item choose-image">
  	  <?php include_partial('aImageSlot/choose', array('action' => 'fParkSlot/image', 'buttonLabel' => __('Choose image', null, 'apostrophe'), 'label' => __('Select an Image', null, 'apostrophe'), 'class' => 'a-btn icon a-media', 'type' => 'image', 'constraints' => array(), 'itemId' => $itemId, 'name' => $name, 'slug' => $slug, 'permid' => $permid)) ?>
  	</li>
  	<?php include_partial('a/simpleEditWithVariants', array('pageid' => $page->id, 'name' => $name, 'permid' => $permid, 'slot' => $slot, 'page' => $page, 'controlsSlot' => false)) ?>
  <?php end_slot() ?>
<?php endif ?>
<div class="park-wrapper <?=$align?>">
  <div class="text">
    <h3><a  href="<?=$url?>"><?=$title?></a></h3>
    <p><?=$text?></p>
  </div>
  <?php if ($itemId): ?>
    <a class="image" href="<?=$url?>"><?=$embed?></a>
  <?php endif ?>
</div>  
