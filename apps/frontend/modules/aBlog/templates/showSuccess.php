<?php use_helper('a') ?>
<?php $page = aTools::getCurrentPage() ?>
<?php slot('body_class') ?>a-blog <?php echo $sf_params->get('module'); ?> <?php echo $sf_params->get('action') ?><?php end_slot() ?>

<div class="left">
  <?php include_component('a', 'subnav', array('page' => $page)) # Subnavigation ?>
</div>
<div class="right">
  <?php echo include_partial('aBlog/post', array('a_blog_post' => $aBlogPost)) ?>
  <?php if($aBlogPost['allow_comments']): ?><?php endif ?>
</div>
