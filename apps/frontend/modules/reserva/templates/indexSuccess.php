<?use_stylesheet("/apostrophePlugin/css/ui-apostrophe/jquery-ui-1.7.2.custom.css");?>

<?php slot('body_class') ?>reserva<?php end_slot() ?>


<div class="left">
  <h3>Reserva</h3>
  <form id="form_reserva" action="<?=url_for('@reserva_index') ?>" method="post">
    <?=$form?>
    <div class="form-row">

			<table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Centro de Estudios</th>
            <th>Centro de Trabajo</th>
          </tr>
        </thead>
        <tbody>
					<? for($i=1;$i<=0;$i++):?>
	          <tr>
	            <td><?=$i?></td>
		          <td>
								<input type="text" name="alojados_cde[]" />
							</td>
		          <td>
								<?if($i<=15):?>
									<input type="text" name="alojados_cdt[]" />
								<?endif?>
							</td>
	          </tr>
					<? endfor?>					
        </tbody>
      </table>
    
    </div>


    <div class="form-row botones">
      <input id="reserva_submit" class="submit" value="Reservar" name="enviar" type="submit" />
    </div>
  </form>
</div>
<div class="right">
  <?php include_partial('a/areaTemplate', array('name' => 'sidebar', 'width' => 350)) ?>
</div>

<?php a_js_call('lareja.reservaInit()') ?>
<?php /*a_js_call('lareja.reservaInit(?)', array(
    'id' => 'game-container',
    'swf' => '/games/swf/'.$game['swf'],
    'width' => $game['width'],
    'height' => $game['height'] 
  )) */?>


