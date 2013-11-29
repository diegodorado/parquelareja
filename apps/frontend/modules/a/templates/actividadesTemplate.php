<?php use_helper('a') ?>
<?php $page = aTools::getCurrentPage() ?>
<?php slot('body_class') ?>default<?php end_slot() ?>

<div class="left">
  <?php include_component('a', 'subnav', array('page' => $page)) # Subnavigation ?>
</div>
<div class="right">
  <div id="events_calendar"></div>
</div>

<script type='text/javascript' src='/js/fullcalendar.js'></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#events_calendar').fullCalendar({
			events: "/calendar_events",
		});
	});
</script>
