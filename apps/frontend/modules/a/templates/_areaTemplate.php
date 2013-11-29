<?php // Reasonable Defaults ?>
<?php $name = isset($name) ? $sf_data->getRaw('name') : 'body'; ?>
<?php $width = isset($width) ? $sf_data->getRaw('width') : 480; ?>
<?php $toolbar = isset($toolbar) ? $sf_data->getRaw('toolbar') : 'Sidebar'; ?>
<?php // Array of all slots we enable ?>
<?php $slots = isset($slots) ? $sf_data->getRaw('slots') : array('aRichText', 'aVideo', 'aImage', 'aSlideshow', 'aSmartSlideshow', 'aFile', 'aAudio', 'aFeed', 'aButton', 'aText', 'aRawHTML','fSnapShot'); ?>

<?php a_area($name, array(
	'allowed_types' => $slots,
  'type_options' => array(
		'aRichText' => array(
		  'tool' => $toolbar,
			// 'allowed-tags' => array(),
			// 'allowed-attributes' => array('a' => array('href', 'name', 'target'),'img' => array('src')),
			// 'allowed-styles' => array('color','font-weight','font-style'),
		),
		'aVideo' => array(
			'width' => $width,
			'height' => false,
			'resizeType' => 's',
			'flexHeight' => true,
			'title' => false,
			'description' => false,
		),
		'aImage' => array(
			'width' => $width,
			'constraints' => array('minimum-width' => $width),
		),
		'aSlideshow' => array(
			'width' => $width,
			'height' => false,
			'resizeType' => 's',
			'flexHeight' => true,
			'constraints' => array('minimum-width' => $width),
			'arrows' => true,
			'interval' => false,
			'random' => false,
			'title' => false,
			'description' => false,
			'credit' => false,
			'position' => false,
			'itemTemplate' => 'slideshowItem',
		),
		'aSmartSlideshow' => array(
			'width' => $width,
			'height' => false,
			'resizeType' => 's',
			'flexHeight' => true,
			'constraints' => array('minimum-width' => $width),
			'arrows' => true,
			'interval' => false,
			'random' => false,
			'title' => false,
			'description' => false,
			'credit' => false,
			'position' => false,
			'itemTemplate' => 'slideshowItem',
		),
		'aFile' => array(
		),
		'aAudio' => array(
			'width' => $width,
			'title' => true,
			'description' => true,
			'download' => true,
			'playerTemplate' => 'default',
		),
		'aFeed' => array(
			'posts' => 5,
			'links' => true,
			'dateFormat' => false,
			'itemTemplate' => 'aFeedItem',
			// 'markup' => '<strong><em><p><br><ul><li><a>',
			// 'attributes' => false,
			// 'styles' => false,
		),
		'aButton' => array(
			'width' => $width,
			'flexHeight' => true,
			'resizeType' => 's',
			'constraints' => array('minimum-width' => $width),
			'rollover' => true,
			'title' => true,
			'description' => false
		),
    'aText' => array(
			'multiline' => false
		),
		'aRawHTML' => array(
		),
	))) ?>
