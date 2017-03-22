<?php use_helper('I18N') ?>
<?php use_helper('a') ?>
<?php // This is a copy of apostrophePlugin/modules/a/templates/layout.php ?>
<?php // It also makes a fine site-wide layout, which gives you global slots on non-page templates ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php // If this page is an admin page we don't want to present normal navigation relative to it. ?>
	<?php $page = aTools::getCurrentNonAdminPage() ?>
  <?php $root = aPageTable::retrieveBySlug('/') ?>
<head>
	<?php // What do you guys think about Chrome frame? It's out of beta now :D ?>
	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>
	<?php // 1.3 and up don't do this automatically (no common filter) ?>
	<?php // a_include_stylesheets has a built in caching combiner/minimizer when enabled ?>
  <?php a_include_stylesheets() ?>

	<?php a_include_javascripts() ?>
	<!--[if lt IE 7]>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				apostrophe.IE6({'authenticated':<?php echo ($sf_user->isAuthenticated())? 'true':'false' ?>, 'message':<?php echo json_encode(__('You are using IE6! That is just awful! Apostrophe does not support editing using Internet Explorer 6. Why don\'t you try upgrading? <a href="http://www.getfirefox.com">Firefox</a> <a href="http://www.google.com/chrome">Chrome</a> 	<a href="http://www.apple.com/safari/download/">Safari</a> <a href="http://www.microsoft.com/windows/internet-explorer/worldwide-sites.aspx">IE8</a>', null, 'apostrophe')) ?>});
			});
		</script>
	<![endif]-->	

	
	<?php if (has_slot('og-meta')): ?>
		<?php include_slot('og-meta') ?>
	<?php endif ?>

	<?php if ($fb_page_id = sfConfig::get('app_a_facebook_page_id')): ?>
		<meta property="fb:page_id" content="<?php echo $fb_page_id ?>" />		
	<?php endif ?>
	
	<link rel="shortcut icon" href="/favicon.ico" />
	
	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" href="/apostrophePlugin/css/a-ie.css" />	
	<![endif]-->
	
</head>

<?php // body_class allows you to set a class for the body element from a template ?>
<body class="<?php if (has_slot('body_class')): ?><?php include_slot('body_class') ?><?php endif ?><?php if (($sf_user->isAuthenticated())): ?> logged-in<?php endif ?>">

	<?php include_partial('a/doNotEdit') ?>
  <?php include_partial('a/globalTools') ?>

	<div id="a-wrapper"  class="a-wrapper clearfix">
    
    <div id="header">
      <?php a_slot("logo", 'aButton', array("global" => true, "width" => 960, "flexHeight" => true, "resizeType" => "s")) ?>
 			<?php include_component('aNavigation', 'tabs', array('root' => '/', 'active' => $page['slug'], 'name' => 'main', 'draggable' => true, 'dragIcon' => false)) # Top Level Navigation ?>
   		<?php if (has_slot('a-breadcrumb')): ?>
   				<?php include_slot('a-breadcrumb') ?>
   		<?php elseif ($page): ?>
   				<?php include_component('aNavigation', 'breadcrumb', array('root' => '/', 'active' => $page['slug'], 'name' => 'component', 'separator' => '|')) # Top Level Navigation ?>
   		<?php endif ?>
    </div>
 		
    <?php if (has_slot('a-subnav')): ?>
  		<div id="content" class="clearfix has-subnav">
  		  <div class="top clearfix">
          <?php if (has_slot('a-page-header')): ?>
			      <?php include_slot('a-page-header') ?>
       		<?php endif ?>
  		  </div>
  		  <div class="middle clearfix">
    		  <div class="left">
  			    <?php include_slot('a-subnav') ?>
    		  </div>
    		  <div class="right">
      		  <?php echo $sf_data->getRaw('sf_content') ?>
    		  </div>
  		  </div>
	    </div>
 		<?php else: ?>
  		<div id="content" class="clearfix">
		    <?php echo $sf_data->getRaw('sf_content') ?>
	    </div>
 		<?php endif ?>
	
    <div id="footer">
      <span>Alfonsina Storni 1568, La Reja - Moreno -Pcia. de Bs. As. - Argentina</span>
    </div>
	</div>
	
  <?php include_partial('a/ga') ?>
  <?php // Invokes apostrophe.smartCSS, your project level JS hook and a_include_js_calls ?>
	<?php include_partial('a/globalJavascripts') ?>



</body>
</html>
