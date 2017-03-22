<?php use_helper('a') ?>
<?php $page = aTools::getCurrentPage() ?>
<?php slot('body_class') ?>a-blog <?php echo $sf_params->get('module'); ?> <?php echo $sf_params->get('action') ?><?php end_slot() ?>

<div class="left">
  <?php include_component('a', 'subnav', array('page' => $page)) # Subnavigation ?>
</div>
<div class="right">
  <div id="a-blog-main" class="a-blog-main">
    <?php foreach ($pager->getResults() as $a_blog_post): ?>
    	<?php echo include_partial('aBlog/post', array('a_blog_post' => $a_blog_post)) ?>
    	<hr />
    <?php endforeach ?>

    <?php if ($pager->haveToPaginate()): ?>
   		<?php echo include_partial('aPager/pager', array('pager' => $pager, 'pagerUrl' => url_for('aBlog/index?'. http_build_query($params['pagination'])))); ?>
    <?php endif ?>

  </div>
</div>
