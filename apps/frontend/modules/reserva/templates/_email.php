<div>
	<label>---IMPORTANTE: NO RESPONDER ESTE MAIL---</label>
</div>
<br>
<div>
	<?php if (isset($guests)) { ?>
		Fecha: <?php echo $fecha_desde; ?> a <?php echo $fecha_hasta; ?><br>
	<?php } else { ?>
		Fecha: <?php echo $fecha; ?><br>
	<?php } ?>	
	<fieldset width="500">
	<legend><b>Responsable</b></legend>
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
	<?php if (isset($comentario)) { ?>
		<b>Comentarios:</b><br><?php echo $comentario; ?>
	<?php } ?>
	</fieldset>
	Importe total de la reserva: <b>$ <?php echo $costo_total; ?></b>
	<?php if(isset($taller)) { ?>
		(NO incluye los costos del taller)
	<?php }?>
</div>
<br>
<?php if (isset($guests)) { ?>
	<?php if (isset($guests['cde'])) { ?>
		<div>
			<hr>Centro de Estudio<hr>
		</div>
		<div>
			<label>DATOS DE LOS ALOJADOS</label>
		</div>
		<br>
		<div>
			<table cellpadding="0" cellspacing="0" border="1">
				<tr>
					<td width="200">�mbito</td>
					<td width="200">Nombre y apellido</td>
					<td width="200">Email</td>
					<td width="200">Importe</td>
				</tr>
			<?php foreach ($guests['cde'] as $guest){ ?>
				<tr>
					<td>Centro de estudios</td>
					<td><?php echo utf8_decode($guest['name']); ?></td>
					<td><?php echo utf8_decode($guest['email']); ?></td>
					<td>$ <?php echo $costos['cde']; ?></td>
				</tr>
			<?php } ?> 
			</table>
		</div>
		<br>
		<div>
			<label>INFORMACI�N PARA EL CALENDARIO</label>
		</div>
		<div>
			<?php for($i=0;$i<count($dates);$i++) { ?>
				<br><b><?php echo $dates[$i]; ?></b><br><br>
				<?php echo 'CdE' . $taller_texto; ?>: <?php echo count($guests['cde']); ?> Alojado<?php if (count($guests['cde'])!=1){echo 's';} ?>. 
				<?php if ($i == 0){ echo 'Ingreso 18:30hs.';} else if ($i == count($dates)-1){ echo 'Egreso 17:30hs.';}?>
				(Resp.	 <?php echo ucfirst(utf8_decode($nombre)) . ' ' . ucfirst(utf8_decode($apellido)); ?>)<br>
			<?php } ?>
		</div>
	<?php } ?>
	<?php if (isset($guests['cdt'])) { ?>	
		<div>
			<hr>Centro de trabajo<hr>
		</div>
		<div>
			<label>DATOS DE LOS ALOJADOS</label>
		</div>
		<br>
		<div>
			<table cellpadding="0" cellspacing="0" border="1">
				<tr>
					<td width="200">�mbito</td>
					<td width="200">Nombre y apellido</td>
					<td width="200">Email</td>
					<td width="200">Importe</td>
				</tr>
			<?php foreach ($guests['cdt'] as $guest){ ?>
				<tr>
					<td>Centro de trabajo</td>
					<td><?php echo utf8_decode($guest['name']); ?></td>
					<td><?php echo utf8_decode($guest['email']); ?></td>
					<td>$ <?php echo $costos['cdt']; ?></td>
				</tr>
			<?php } ?> 
			</table>
		</div>
		<br>
		<div>
			<label>INFORMACI�N PARA EL CALENDARIO</label>
		</div>
		<div>
			<?php for($i=0;$i<count($dates);$i++) { ?>
				<br><b><?php echo $dates[$i]; ?></b><br><br>
				<?php echo 'CdT' . $taller_texto; ?>: <?php echo count($guests['cdt']); ?> Alojado<?php if (count($guests['cdt'])!=1){echo 's';} ?>. 
				<?php if ($i == 0){ echo 'Ingreso 18:30hs.';} else if ($i == count($dates)-1){ echo 'Egreso 17:30hs.';}?>
				(Resp.	 <?php echo ucfirst(utf8_decode($nombre)) . ' ' . ucfirst(utf8_decode($apellido)); ?>)<br>
			<?php } ?>
		</div>
	<?php } ?>
<?php } ?>
<?php if (isset($taller)) { ?>
	<div>
		<hr>Taller<hr>
	</div>
	<br>
	<div>
		<b>Actividades a realizar:</b><br>
		<?php foreach($taller['actividades'] as $key => $value) { ?>
			&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $actividades_taller[$key]; ?><br>
		<?php } ?>
		<b>Cantidad de Participantes:</b> <?php echo $taller['cantidad']; ?><br>
		<?php if (isset($taller['comentario'])) { ?>
			<b>Comentarios:</b><br><?php echo $taller['comentario']; ?>
		<?php } ?>
	</div>
<?php } ?>