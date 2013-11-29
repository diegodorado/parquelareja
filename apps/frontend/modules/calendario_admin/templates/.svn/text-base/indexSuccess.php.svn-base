<?php use_helper('a') ?>
<?php slot('body_class') ?>calendario<?php end_slot() ?>

<div class="left">
  <h3>Calendario de Uso</h3>
  <p>Haga click en un ámbito para ver su disponibilidad.</p>
  <div id="calendar_filters">
    <h5 data-type="all" class="all selected">Todos</h5>
    <h5 data-type="cde" class="cde">Centro de Estudios</h5>
    <h5 data-type="cdt" class="cdt">Centro de Trabajo</h5>
    <h5 data-type="taller" class="taller">Taller</h5>
  </div>
  <p><b>Las reservas de taller aún no se muestran aquí</b> aunque si figuran en los detalles.</p>
  <p>Haga click en una fecha del calendario para editar los detalles de reservas de ese día.</p>
  <div id="calendar_details">
    <div id="calendar_details_content" style="display:none;">
    </div>
  </div>
</div>
<div class="right">
  <div id="calendar" class="all">
    <? echo $cal->getHTML(true);?>
  </div>
</div>

<?php a_js_call('lareja.calendarInit()') ?>

