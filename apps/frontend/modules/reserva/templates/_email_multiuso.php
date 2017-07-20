<!--<div>
	<label>---IMPORTANTE: NO RESPONDER ESTE MAIL---</label>
</div>-->
<br>
<div>
	<h3><?php echo $actividad; ?></h3>
	Fecha: <?php echo $fecha; ?><br><br>
	<fieldset width="500">
		<legend><b>Responsable</b></legend>
		<?php echo $nombre . ' ' . $apellido; ?><br>
		<?php echo $solicitante; ?><br>
		<?php echo $email; ?><br>
		<?php echo $telefono; ?><br><br>
	</fieldset>
	<label><b>Horario</b>: de <?php echo $horario_desde." a ".$horario_hasta; ?></label><br>
	<label><b>Cantidad de personas</b>: <?php echo $cantidad; ?></label>
</div>
