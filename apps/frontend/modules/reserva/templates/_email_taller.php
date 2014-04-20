<div>
	<label>---IMPORTANTE: NO RESPONDER ESTE MAIL---</label>
</div>
<br>
<div>
	Fecha: <?php echo $fecha_desde; ?> a <?php echo $fecha_hasta; ?><br>
	<fieldset width="500">
	<legend>Responsable</legend>
	<?php echo utf8_decode($nombre) . ' ' . utf8_decode($apellido); ?>
	(<?php 
	if ($solicitante == 'maestro'){
		echo 'Maestro';
	}
	else if ($solicitante == 'mensaje'){
		echo 'Comunidad del mensaje "'.$comunidad.'"';
	}
	else{
		echo $organismos[$organismo];
	}
	?>)<br>
	<?php echo $email; ?><br>
	<?php echo $telefono; ?><br>
	</fieldset>
	Importe de la reserva: El sistema no calcula el costo del taller. 
</div>
<br>
<div>
	<label>DATOS DEL TALLER</label>
</div>
<br>
<div>
	<b>Actividades a realizar:</b><br>
	<?php foreach($taller['actividades'] as $key => $value) { ?>
		&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $actividades_taller[$key]; ?><br>
	<?php } ?>
	<b>Cantidad de Participantes:</b> <?php echo $taller['cantidad']; ?>
</div>
