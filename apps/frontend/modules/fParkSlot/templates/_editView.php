<?php use_helper('I18N') ?>
<?php if ($form['url']->hasError()): ?>
  <div class="a-error"><?php echo __('Invalid URL. A valid example: http://www.punkave.com/', null, 'apostrophe') ?></div>
<?php endif ?>
<?=$form?>
