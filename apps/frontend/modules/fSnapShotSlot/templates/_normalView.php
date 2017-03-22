<?php use_helper('I18N') ?>
<?php if ($editable): ?>
  <?php slot("a-slot-controls-$pageid-$name-$permid") ?>
  	<li class="a-controls-item choose-image">
  	  <?php include_partial('aImageSlot/choose', array('action' => 'fSnapShotSlot/image', 'buttonLabel' => __('Choose image', null, 'apostrophe'), 'label' => __('Select an Image', null, 'apostrophe'), 'class' => 'a-btn icon a-media', 'type' => 'image', 'constraints' => array(), 'itemId' => $itemId, 'name' => $name, 'slug' => $slug, 'permid' => $permid)) ?>
  	</li>
  	<?php include_partial('a/simpleEditWithVariants', array('pageid' => $page->id, 'name' => $name, 'permid' => $permid, 'slot' => $slot, 'page' => $page, 'controlsSlot' => false)) ?>
  <?php end_slot() ?>
<?php endif ?>
<div class="f-snapshot-wrapper <?=$align?>">
  <div class="text">
    <h4>
      <?if($url):?><a  href="<?=$url?>"><?=$title?></a>
      <?else:?><?=$title?>
      <?endif?>
    </h4>
    <p><?=$text?></p>
  </div>
  <?php if ($itemId): ?>
    <div class="image">
    <?if($url):?><a href="<?=$url?>"><?=$embed?></a>
    <?else:?><?=$embed?>
    <?endif?>
    </div>
  <?php endif ?>
</div>
