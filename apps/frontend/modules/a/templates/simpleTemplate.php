<?php use_helper('a') ?>
<?php $page = aTools::getCurrentPage() ?>
<?php slot('body_class') ?>simple<?php end_slot() ?>

<div class="center">
  <?php include_partial('a/areaTemplate', array('name' => 'body-simple', 'width' => 920)) ?>
</div>

