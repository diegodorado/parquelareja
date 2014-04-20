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
	Importe total de la reserva: <b>ARS <?php echo $costo_total; ?></b>
	<?php if(false) { ?>
		(NO incluye los costos del taller)
	<?php }?>
</div>
<br>
<div>
	<label>DATOS DE LOS ALOJADOS</label>
</div>
<br>
<div>
	<table cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td width="200">Ámbito</td>
			<td width="200">Nombre y apellido</td>
			<td width="200">Email</td>
			<td width="200">Importe</td>
		</tr>
	<?php foreach ($guests[$ambito] as $guest){ ?>
		<tr>
			<td><?php echo $ambito_nombre; ?></td>
			<td><?php echo utf8_decode($guest['name']); ?></td>
			<td><?php echo utf8_decode($guest['email']); ?></td>
			<td>ARS <?php echo $costos[$ambito]; ?></td>
		</tr>
	<?php } ?> 
	</table>
</div>
<br>
<div>
	<label>INFORMACIÓN PARA EL CALENDARIO</label>
</div>
<div>
	<?php for($i=0;$i<count($dates);$i++) { ?>
		<br><b><?php echo $dates[$i]; ?></b><br><br>
		<?php echo $ambito_abreviacion . $taller_texto; ?>: <?php echo count($guests[$ambito]); ?> Alojado<?php if (count($guests[$ambito])!=1){echo 's';} ?>. 
		<?php if ($i == 0){ echo 'Ingreso 18:30hs.';} else if ($i == count($dates)-1){ echo 'Egreso 17:30hs.';}?>
		(Resp.	 <?php echo ucfirst(utf8_decode($nombre)) . ' ' . ucfirst(utf8_decode($apellido)); ?>)<br>
	<?php } ?>
</div>
