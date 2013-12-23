<?php use_helper('a') ?>
<?php slot('body_class') ?>calendario<?php end_slot() ?>

<div class="left">
  <h3>Calendario de Uso</h3>
  <p>Haga click en un ámbito para ver su disponibilidad.</p>
  <div id="calendar_filters">
    <h5 data-type="cde" class="cde selected">Centro de Estudios</h5>
    <h5 data-type="cdt" class="cdt">Centro de Trabajo</h5>
  </div>
  <p><b>Las reservas de taller aún no se muestran aquí</b> aunque si figuran en los detalles.</p>
  <p>Haga click en una fecha del calendario para ver los detalles de reservas de ese día.</p>
  <div id="calendar_details">
    <div id="calendar_details_content" style="display:none;">
    </div>
  </div>
</div>
<div class="right">
  <div id="calendar" class="cde">
    <? echo $cal->getHTML();?>
  </div>
</div>

<script type='text/javascript'>
	$(document).ready(function() {
		$('#calendar_filters h5').click(function(e){
  		$('#calendar_filters h5').removeClass('selected');
  		$(this).addClass('selected');
  		$('#calendar').attr('class','');
  		$('#calendar').addClass($(this).attr('data-type'));
		});
	});
</script>

<div></div>

