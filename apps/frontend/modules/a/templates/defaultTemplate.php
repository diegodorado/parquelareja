<?php use_helper('a') ?>
<?php $page = aTools::getCurrentPage() ?>
<?php slot('body_class') ?>default<?php end_slot() ?>

<div class="left">
  <?php include_component('a', 'subnav', array('page' => $page)) # Subnavigation ?>
</div>
<div class="right">
  <div class="top clearfix">
    <?php include_partial('a/areaTemplate', array('name' => 'body', 'width' => 720)) ?>
  </div>
  <div class="middle clearfix">
    <div class="left">
      <?php include_partial('a/areaTemplate', array('name' => 'middle-left', 'width' => 350)) ?>
    </div>
    <div class="right">
      <?php include_partial('a/areaTemplate', array('name' => 'middle-right', 'width' => 350)) ?>
    </div>
  </div>
  <div class="bottom clearfix">
    <?php include_partial('a/areaTemplate', array('name' => 'bottom', 'width' => 350)) ?>
  </div>
</div>
