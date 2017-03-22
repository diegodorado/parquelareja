<?php use_helper('a') ?>
<?php slot('body_class') ?>home<?php end_slot() ?>
<?php // Breadcrumb is removed for the home page template because it is redundant ?>
<?php slot('a-breadcrumb', '') ?>

<div class="left">
  <?php include_partial('a/areaTemplate', array('name' => 'leftbar', 'width' => 180)) ?>
</div>
<div class="center">
  <div class="top clearfix">
    <?php include_partial('a/areaTemplate', array('name' => 'body', 'width' => 500)) ?>
  </div>
  <div class="bottom clearfix">
    <div class="left">
      <?php include_partial('a/areaTemplate', array('name' => 'bottom-left', 'width' => 240)) ?>
    </div>
    <div class="right">
      <?php include_partial('a/areaTemplate', array('name' => 'bottom-right', 'width' => 240)) ?>
    </div>
  </div>
</div> 
<div class="right">
  <?php include_partial('a/areaTemplate', array('name' => 'sidebar', 'width' => 200)) ?>
</div>
