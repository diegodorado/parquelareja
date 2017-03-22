<?use_stylesheet("/apostrophePlugin/css/ui-apostrophe/jquery-ui-1.7.2.custom.css");?>

<?php slot('body_class') ?>reserva simple<?php end_slot() ?>



<script type="text/javascript" src="/js/jquery.easyModal.js"></script>
<div class="center">
  <!--<form id="form_reserva" action="<?=url_for('@reserva_index') ?>" method="post">-->
	<input type="hidden" id="remoteip" value="<?php echo $remoteip; ?>">
	<div id="Opciones">
		<input type="button" class="opcion reserva" value="">
		<input type="button" class="opcion aviso_uso" value="">
	</div>
	<div id="Opciones_reserva">
		<div>
			<input type="checkbox" class="alojamiento">
			<label>Centros</label>
		</div>
		<div>
			<input type="checkbox" class="taller">
			<label>Taller</label>
		</div>
		<div class="error_message medium">Seleccioná si querés reservar Centros y/o Taller</div>
		<input type="button" value="Continuar" class="boton continuar">
	</div>
	<form id="form_aviso_uso" action="" method="post">
		<h3>Aviso de uso de la multiuso</h3>
		<div class="area_content columna_grande izquierda">
            <div class="field_set">
                <div class="field solicitante">
                   <div class="column denominacion">
                        <label>Solicitante (requerido)</label>
                   </div>
                   <div class="column valor">
                        <select class="input tipo_solicitante" name="solicitante">
                            <option value="maestro">Maestro</option>
                            <option value="mensaje">El Mensaje de Silo</option>
                            <option value="organismo">Organismo</option>
                        </select>
                   </div>
                </div>
                <div class="field organismo particular">
                   <div class="column denominacion">
                        <label>Organismo (requerido)</label>
                   </div>
                   <div class="column valor">
                        <select class="input tipo_solicitante" name="organismo">
                            <option value="ceh">Centro Mundial de Estudios Humanistas</option>
                            <option value="cc">Convergencia de las Cuturas</option>
                            <option value="cdh">La Comunidad (para el desarrollo humano)</option>
                            <option value="msg">Mundo sin Guerras y sin violencia</option>
                            <option value="ph">Partido Humanista</option>
                        </select>
                   </div>

                </div>
					<div class="field equipo particular">
					   <div class="column denominacion">
							<label>Equipo de base</label>
					   </div>
						<div class="column valor">
							<input type="text" class="input equipo_de_base xwide required" name="equipo_de_base" placeholder="Equipo de Base o Grupo Promotor (requerido)">
							<div class="error_message equipo_de_base required">
								<label>Este dato es requerido!</label>
							</div>
						</div>
					</div>
                <div class="field comunidad particular">
                   <!--<div class="column denominacion">
                        <label>Comunidad (requerido)</label>
                   </div>-->
                   <div class="column valor">
										<input type="text" name="comunidad" value="" class="input comunidad wide required" placeholder="Comunidad (requerido)">
						   <div class="error_message comunidad required">
								<label>Este dato es requerido!</label>
						   </div>
                   </div>
                </div>
            </div>
		  <div class="field_set">
			  <div class="titulo_set">
				  <label>Datos de contacto</label>
			  </div>
			  <div class="field nombre">
				   <!--<div class="column denominacion">
						<label>Nombre (requerido)</label>
				   </div>-->
				   <div class="column valor">
					   <input type="text" class="input nombre wide required" name="nombre" placeholder="Nombre (requerido)">
					   <div class="error_message nombre required">
							<label>Este dato es requerido!</label>
					   </div>
				   </div>
			  </div>
			  <div class="field nombre">
				   <!--<div class="column denominacion">
						<label>Apellido(s) (requerido)</label>
				   </div>-->
				   <div class="column valor">
					   <input type="text" class="input apellido wide required" name="apellido" placeholder="Apellido(s) (requerido)">
					   <div class="error_message apellido required">
							<label>Este dato es requerido!</label>
					   </div>
				   </div>
			  </div>
			  <div class="field email">
				   <!--<div class="column denominacion">
						<label>E-mail (requerido)</label>
				   </div>-->
				   <div class="column valor">
						<input type="text" class="input email wide required" name="email" placeholder="Email (requerido)">
						<div class="error_message email required">
							<label>Este dato es requerido!</label>
						</div>
						<div class="error_message email format">
							<label>La dirección de mail no parece válida!</label>
						</div>
				   </div>
			  </div>
			  <div class="field telefono">
				   <!--<div class="column denominacion">
						<label>Teléfono/Celular (requerido)</label>
				   </div>-->
				   <div class="column valor">
						<input type="text" class="input telefono required" name="telefono" placeholder="Teléfono/Celular (requerido)">
						<div class="error_message telefono required">
							<label>Este dato es requerido!</label>
						</div>
						<div class="error_message telefono format">
							<label>Este campo debe contener solo números</label>
						</div>
				   </div>
			  </div>
			  <div class="field fecha">
				   <!--<div class="column denominacion">
						<label>Fecha</label>
				   </div>-->
				   <div class="column valor">
						<input type="text" class="input fecha required" name="fecha" readonly placeholder="Fecha">
						<div class="error_message fecha required">
							<label>Este dato es requerido!</label>
						</div>
				   </div>
			  </div>
			  <div class="field horario">
				   <div class="column denominacion">
						<label>Horario</label>
				   </div>
				   <div class="column valor">
						De <select class="input horario desde required" name="horario_desde" disabled>
							<?php for ($i=$horario_desde;$i<$horario_hasta+1;$i++) {
							$hora = $i;
							if ($i < 10){
								$hora = '0'.$hora;
							} ?>
							<option><?php echo $hora; ?></option>
							<?php } ?>
						</select>
						a <select class="input horario hasta required" name="horario_hasta" disabled>
							<?php for ($i=$horario_desde+1;$i<$horario_hasta+1;$i++) {
							$hora = $i;
							if ($i < 10){
								$hora = '0'.$hora;
							} ?>
							<option><?php echo $hora; ?></option>
							<?php } ?>
						</select> hs.
						<div class="error_message horario">
							<label>El horario de fin debe ser menor al horario de comienzo</label>
						</div>
				   </div>
			  </div>
			  <div class="field cantidad">
				   <!--<div class="column denominacion">
						<label>Cantidad de personas</label>
				   </div>-->
				   <div class="column valor">
						<input type="text" class="input cantidad required number" name="cantidad" placeholder="Cantidad de personas">
						<div class="error_message cantidad required">
							<label>Este dato es requerido!</label>
						</div>
						<div class="error_message cantidad number">
							<label>Este campo solo puede contener números</label>
						</div>
				   </div>
			  </div>
			  <div class="field actividad">
				   <!--<div class="column denominacion">
						<label>Actividad</label>
				   </div>-->
				   <div class="column valor">
						<textarea cols="29" rows="5" class="input actividad required" name="actividad" placeholder="Actividad"></textarea>
						<div class="error_message actividad required">
							<label>Este dato es requerido!</label>
						</div>
				   </div>
			  </div>
		  </div>
	  </div>
	  <!--<div class="columna_grande derecha">
		<input class="helpButton1" type="button" value="como hacer esto">
		<input class="helpButton2" value="como hacer aquello">
		<input class="helpButton3" value="bla bla bla">
		<input class="helpButton4" value="blu blu blu">
	  </div>-->
	<div class="form-row botones">
		<input id="aviso_uso_submit" class="boton_reserva" value="Avisar" name="enviar" type="button" />
	</div>

  </form>
  <form id="form_reserva" action="" method="post">
  	<h3>Reserva - Paso 1</h3>
	<div class="columna_grande izquierda">
		<div class="area general">
			  <div class="titulo_area">
				   <label>SOLICITANTE</label>
			  </div>
			  <div class="area_content">
				<div class="field_set">
					<div class="field solicitante">
					   <div class="column denominacion">
							<label>Solicitante (requerido)</label>
					   </div>
					   <div class="column valor">
							<select class="input tipo_solicitante" name="solicitante">
								<option value="maestro">Maestro</option>
								<option value="mensaje">El Mensaje de Silo</option>
								<option value="organismo">Organismo</option>
							</select>
					   </div>
					</div>
					<div class="field organismo particular">
					   <div class="column denominacion">
							<label>Organismo (requerido)</label>
					   </div>
					   <div class="column valor">
							<select class="input organismos" name="organismo">
								<option value="ceh">Centro Mundial de Estudios Humanistas</option>
								<option value="cc">Convergencia de las Cuturas</option>
								<option value="cdh">La Comunidad (para el desarrollo humano)</option>
								<option value="msg">Mundo sin Guerras y sin violencia</option>
								<option value="ph">Partido Humanista</option>
							</select>
					   </div>
					</div>
					<div class="field equipo particular">
					   <div class="column denominacion">
							<label>Equipo de base</label>
					   </div>
						<div class="column valor">
							<input type="text" class="input equipo_de_base xwide required" name="equipo_de_base" placeholder="Equipo de Base o Grupo Promotor (requerido)">
							<div class="error_message equipo_de_base required">
								<label>Este dato es requerido!</label>
							</div>
						</div>
					</div>
					<div class="field comunidad particular">
					   <!--<div class="column denominacion">
							<label>Comunidad (requerido)</label>
					   </div>-->
					   <div class="column valor">
							<input type="text" name="comunidad" value="" class="comunidad wide required" placeholder="Comunidad (requerido)">
							   <div class="error_message comunidad required">
									<label>Este dato es requerido!</label>
							   </div>
					   </div>
					</div>
				</div>
				  <div class="field_set">
					  <div class="titulo_set">
						  <label>Datos de contacto</label>
					  </div>
					  <div class="field nombre">
						   <!--<div class="column denominacion">
								<label>Nombre (requerido)</label>
						   </div>-->
						   <div class="column valor">
							   <input type="text" class="input nombre wide required" name="nombre" placeholder="Nombre (requerido)">
							   <div class="error_message nombre required">
									<label>Este dato es requerido!</label>
							   </div>
						   </div>
					  </div>
					  <div class="field nombre">
						   <!--<div class="column denominacion">
								<label>Apellido(s) (requerido)</label>
						   </div>-->
						   <div class="column valor">
							   <input type="text" class="input apellido wide required" name="apellido" placeholder="Apellido(s) (requerido)">
							   <div class="error_message apellido required">
									<label>Este dato es requerido!</label>
							   </div>
						   </div>
					  </div>
					  <div class="field email">
						   <!--<div class="column denominacion">
								<label>E-mail (requerido)</label>
						   </div>-->
						   <div class="column valor">
								<input type="text" class="input email wide required" name="email" placeholder="E-mail (requerido)">
								<div class="error_message email required">
									<label>Este dato es requerido!</label>
								</div>
								<div class="error_message email format">
									<label>La dirección de mail no parece válida!</label>
								</div>
						   </div>
					  </div>
					  <div class="field telefono">
						   <!--<div class="column denominacion">
								<label>Teléfono/Celular (requerido)</label>
						   </div>-->
						   <div class="column valor">
								<input type="text" class="input telefono wide required" name="telefono" placeholder="Teléfono/Celular (requerido)">
								<div class="error_message telefono required">
									<label>Este dato es requerido!</label>
								</div>
						   </div>
					  </div>
					  <div class="field comentario">
						   <!--<div class="column denominacion">
								<label>Comentarios (opcional)</label>
						   </div>-->
						   <div class="column valor">
								<textarea class="input comentario" name="comentario" rows="4" cols="30" placeholder="Comentarios (opcional)"></textarea>
						   </div>
					  </div>
				  </div>
				  <div class="field_set fecha alojamiento">
					  <div class="titulo_set">
						  <label>Fecha</label>
					  </div>

					  <div class="field  fecha desde">
							<div class="column denominacion">
								<label>Ingreso (requerido)</label>
							</div>
							<div class="column valor">
								<input type="text" class="input fecha desde required" name="fecha_desde" readonly>
								<div class="error_message fecha required">
									<label>Este dato es requerido!</label>
								</div>
							</div>
					  </div>
					  <div class="field  fecha hasta">
						   <div class="column denominacion">
								<label>Egreso (requerido)</label>
						   </div>
						   <div class="column valor">
								<input type="text" class="input fecha hasta required" name="fecha_hasta" readonly>
								<div class="error_message fecha required">
									<label>Este dato es requerido!</label>
								</div>
								<div class="warning_message fecha datePosition">
									<label>Atención: Reserva retrospectiva!</label>
								</div>
						   </div>
					  </div>
				  </div>
				<div class="field_set fecha taller">
					<div class="field  fecha hasta">
						<div class="column denominacion">
						<label>Fecha</label>
					</div>
					<div class="column valor">
						<input type="text" class="input fecha unica required" name="fecha" readonly>
						<div class="error_message fecha required">
							<label>Este dato es requerido!</label>
						</div>
						<div class="warning_message fecha datePosition">
							<label>Atención: Reserva retrospectiva!</label>
						</div>
					</div>
					</div>
				</div>
			  </div>
			  <div class="text_align_center">
				<input type="button" class="boton continuar" value="Continuar">
			  </div>
		 </div>
		 <div class="superarea alojamiento_taller columna_grande izquierda">
			 <div class="general_data">
				<div class="column left">
					<span class="titulo">Responsable</span><br>
					<span class="nombre_apellido"></span><br>
					<span class="equipo"></span><br>
					<span class="organismo"></span><br>
					<span class="email"></span><br>
					<span class="telefono"></span><br>
					<!--<span class="titulo comentario"><br>Comentarios (opcional)<br></span>
					<span class="texto comentario"></span>-->
				</div>
				<div class="column right">
					<span class="palabra desde">Desde</span><br>
					<span class="fecha desde"></span><br>
					<span class="palabra hasta">Hasta</span><br>
					<span class="fecha hasta"></span><br>
				</div>
			 </div>
			 <div class="area alojamiento">
				<div class="titulo_area">
				   <label>CENTROS</label>
				</div>
				<div class="area_content">
					<div class="ambito cde">
						<input type="hidden" class="nombre_ambito" value="cde">
						<div class="titulo_ambito">
							<div class="column checkbox"><input type="checkbox"></div>
							<div class="column text"><label>Centro de Estudio</label></div>
						</div>
						<div class="area_desplegable">
							<div class="field_set">
								<div class="titulo_set">
									<div class="column left">

									</div>
									<div class="column">
										<label>1 alojado </label>
										<span class="mover_responsable_box">
											<input class="mover_responsable" type="button" value="Mover responsable a este ambito">
										</span>
										<span class="centro_completo">Centro completo!</span>
									</div>
								</div>
								<div class="field guest">
								   <div class="column denominacion">
										<label>Alojado 1</label>
								   </div>
									<div class="column valor">
										<!--<label class="guest_name">Nobre y apellido</label>-->
										<input type="text" name="guests[cde][0][name]" class="guest_name required" placeholder="Nombre y apellido(s) (requerido)">
										<!--<label class="guest_email">Email</label>-->
										<input type="text" name="guests[cde][0][email]" class="guest_email email medium required" placeholder="Email (requerido)">
										&nbsp;&nbsp;&nbsp;<a class="remove_guest">Eliminar alojado</a>
										<div class="error_message email format">
											<label>La dirección de mail no parece válida!</label>
										</div>
									</div>
								</div>
								<div class="error_message lodging cde">
									<label>Hay campos sin completar. Complete todos los campos o elimine a los alojados que estén de más</label>
								</div>
								<div class="error_message repeated_emails cde">
									<label>Hay campos de mail repetidos. Todas las direcciones de correo deben ser únicas</label>
								</div>
								<div><input type="button" class="new_guest button" value="Agregar Alojado"></div>
							</div>
						</div>
					</div>
					<div class="ambito cdt">
						<input type="hidden" class="nombre_ambito" value="cdt">
						<div class="titulo_ambito">
							<div class="column checkbox"><input type="checkbox"></div>
							<div class="column text"><label>Centro de Trabajo</label></div>
						</div>
						<div class="area_desplegable">
							<div class="field_set">
								<div class="titulo_set">
									<div class="column left">
									</div>
									<div class="column">
										<label>1 alojado </label>
										<span class="mover_responsable_box">
											<input class="mover_responsable" type="button" value="Mover responsable a este ambito">
										</span>
										<span class="centro_completo">Centro completo!</span>
									</div>
								</div>
								<div class="field guest">
								   <div class="column denominacion">
										<label>alojado 1</label>
								   </div>
									<div class="column valor">
										<!--<label class="guest_name">Nombre y apellido</label>-->
										<input type="text" name="guests[cdt][0][name]" class="guest_name required" placeholder="Nombre y apellido(s) (requerido)">
										<!--<label class="guest_email">Email</label>-->
										<input type="text" name="guests[cdt][0][email]" class="guest_email email medium required" placeholder="E-mail (requerido)">
										&nbsp;&nbsp;&nbsp;<a class="remove_guest">Eliminar alojado</a>
										<div class="error_message email format">
											<label>La dirección de mail no parece válida!</label>
										</div>
									</div>
								</div>
								<div class="error_message lodging cdt">
									<label>Hay campos sin completar. Complete todos los campos o elimine los alojadoes que estén de más</label>
								</div>
								<div class="error_message repeated_emails cdt">
									<label>Hay campos de mail repetidos. Todas las direcciones de correo deben ser únicas</label>
								</div>
								<div><input type="button" class="new_guest button" value="Agregar Alojado"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="error_message lodging_area">
					<label>Tenés que seleccionar al menos un Centro a reservar</label>
				</div>
			 </div>
			 <div class="area ambitos">
				  <div class="titulo_area">
					   <label>TALLER</label>
				  </div>
				  <div class="area_content">
					  <div class="ambito taller">
						<!--<input type="hidden" class="nombre_ambito" value="taller">
						<div class="titulo_ambito">
							<div class="column checkbox"><input type="checkbox"></div>
							<div class="column text"><label>Reservar</label></div>
						</div>-->
						<div class="area_desplegada">
							<div class="field_set">
								<div class="field actividad">
									<div class="column denominacion">
										<label>Actividades a Realizar (requerido)</label>
									</div>
									<div class="column valor">
										<input type="checkbox" name="taller[actividades][ceramica]">
										<label>Cer&aacute;mica</label><br>
										<input type="checkbox" name="taller[actividades][metales]">
										<label>Metales</label><br>
										<input type="checkbox" name="taller[actividades][perfumeria]">
										<label>Perfumer&iacute;a</label><br>
										<input type="checkbox" name="taller[actividades][fuego]">
										<label>Producci&oacute;n y conservaci&oacute;n del fuego</label><br>
										<input type="checkbox" name="taller[actividades][frio]">
										<label>Trabajos en fr&iacute;o</label><br>
										<input type="checkbox" name="taller[actividades][vidrio]">
										<label>Vidrio</label><br>
										<div class="error_message required">
											<label>Debe elegir al menos una actividad</label>
										</div>
									</div>
								</div>
								<div class="field cantidad">
								   <div class="column denominacion">
										<label>Cantidad de participantes (requerido)</label>
								   </div>
									<div class="column valor">
										<input type="number" class="small required number" name="taller[cantidad]">
										<div class="error_message required">
											<label>Este dato es requerido!</label>
										</div>
									</div>
								</div>
							</div>
							<div class="leyenda">El horario de uso de taller  por el día (sin alojamiento) es de <span class="openingTime">10</span>:00 a <span class="closingTime">22</span>:00hs.</div>
							<div class="field_set">
								<div class="field comentario">
								   <div class="column denominacion">
										<label>Comentarios</label>
								   </div>
									<div class="column valor">
										<textarea name="taller[comentario]" cols="40"rows="3"></textarea>
									</div>
								</div>
							</div>
						</div>
					  </div>
				  </div>
			 </div>
			 <!--<div class="captcha_box">
				<script type="text/javascript"
					src="http://www.google.com/recaptcha/api/challenge?k=6LeV7fISAAAAABH4YgN3UXTcEq9N1-7J3LleM6BE">
				</script>
				<noscript>
					<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LeV7fISAAAAAMMubxtHpWLHvWLXe6Z6O5gfxjrJ"
					height="300" width="500" frameborder="0"></iframe><br>
					<textarea name="recaptcha_challenge_field" rows="3" cols="40">
					</textarea>
					<input type="hidden" name="recaptcha_response_field"
					value="manual_challenge">
				</noscript>
			  </div>-->
			<div class="text_align_center">
				<input type="button" class="boton continuar" value="Reservar">
			</div>
		</div>
	</div>
	<!--
	<div class="columna_grande derecha">
		<input class="helpButton1" type="button" value="como hacer esto">
		<input class="helpButton2" value="como hacer aquello">
		<input class="helpButton3" value="bla bla bla">
		<input class="helpButton4" value="blu blu blu">
	</div>
	-->
	<div class="error_message nada_reservado">
		<label>No reservaste nada. Algo tenés que reservar. ¿Para que entraste?</label>
	</div>
</form>
	<div class="dialogs">
		<div id="dialog_1" title="Como hacer esto">
			<p>Ejemplo de dialogo numero 1.</p>
			<p>Ayuda  a los otros humanistas a concretar una reserva en su parque de estudio y reflexion</p>
		</div>
		<div id="dialog_2" title="Como hacer aquello">
			<p>Ejemplo de dialogo numero 2.</p>
			<p>Ayuda  a los otros humanistas a concretar una reserva en su parque de estudio y reflexion</p>
		</div>
		<div id="dialog_3" title="bla bla bla">
			<p>Ejemplo de dialogo numero 3.</p>
			<p>Ayuda  a los otros humanistas a concretar una reserva en su parque de estudio y reflexion</p>
		</div>
		<div id="dialog_4" title="blu blu blu">
			<p>Ejemplo de dialogo numero 4.</p>
			<p>Ayuda  a los otros humanistas a concretar una reserva en su parque de estudio y reflexion</p>
		</div>
	</div>
</div>


<?php a_js_call('lareja.reservaInit(?)', array(
    'test' => $titulo
  )) ?>
