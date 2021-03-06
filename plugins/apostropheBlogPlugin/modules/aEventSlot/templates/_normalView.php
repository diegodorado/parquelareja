<?php // You'll see blog post-related variable names here because we inherit most ?>
<?php // of the implementation from the blog posts slot ?>
<?php
  // Compatible with sf_escaping_strategy: true
  $editable = isset($editable) ? $sf_data->getRaw('editable') : null;
  $aBlogPosts = isset($aBlogPosts) ? $sf_data->getRaw('aBlogPosts') : null;
  $name = isset($name) ? $sf_data->getRaw('name') : null;
  $options = isset($options) ? $sf_data->getRaw('options') : null;
  $page = isset($page) ? $sf_data->getRaw('page') : null;
  $permid = isset($permid) ? $sf_data->getRaw('permid') : null;
  $slot = isset($slot) ? $sf_data->getRaw('slot') : null;
?>

<?php use_helper('a') ?>
<?php if ($editable): ?>
	<?php include_partial('a/simpleEditWithVariants', array('pageid' => $page->id, 'name' => $name, 'permid' => $permid, 'slot' => $slot, 'page' => $page, 'label' => a_get_option($options, 'editLabel', a_('Choose Events')))) ?>
<?php endif ?>

<?php if (count($aBlogPosts)): ?>
	<?php foreach ($aBlogPosts as $aBlogPost): ?>
		<?php $options['slideshowOptions']['idSuffix'] = 'aBlogSlot-'.$permid.'-'.$slot.'-'.$aBlogPost->getId(); ?>	
		<?php include_partial('aEventSingleSlot/post', array('options' => $options, 'aBlogItem' => $aBlogPost)) ?>
	<?php endforeach ?>
<?php else: ?>
	<h4><?php echo a_('There are no events that match the criteria you have specified.') ?></h4>
<?php endif ?>