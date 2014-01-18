<?use_stylesheet("/apostrophePlugin/css/ui-apostrophe/jquery-ui-1.7.2.custom.css");?>

<?php slot('body_class') ?>reserva simple<?php end_slot() ?>


<div class="center">
  <h3>Reserva</h3>
  <form id="form_reserva" action="<?=url_for('@reserva_index') ?>" method="post">
  
     <div class="area general">
          <div class="titulo_area">
               <label>SOLICITANTE</label>
          </div>
          <div class="area_content">
            <div class="field_set">               
                <div class="field solicitante">
                   <div class="column denominacion">
                        <label>Tipo de solicitante</label>
                   </div>
                   <div class="column valor" name="solicitante">
                        <select class="input tipo_solicitante">
                            <option value="maestro">Maestro</option>
                            <option value="organismo">Organismo</option>
                            <option value="mensaje">Mensaje de silo</option>
                        </select>
                   </div>
                </div>
            </div>
              <div class="field_set">
                  <div class="titulo_set">
                      <label>Responsable</label>               
                  </div>  
                  <div class="field nombre">
                       <div class="column denominacion">
                            <label>Nombre y apellido</label>
                       </div>
                       <div class="column valor">
                            <input type="text" class="input nombre" name="responsable">
                       </div>
                       <div class="error_message nombre required">
                        <label>Este campo es obligatorio</label>
                       </div>
                  </div>
                  <div class="field telefono">
                       <div class="column denominacion">
                            <label>Teléfono</label>
                       </div>
                       <div class="column valor">
                            <input type="text" class="input telefono" name="telefono">
                       </div>
                       <div class="error_message telefono required">
                        <label>Este campo es obligatorio</label>
                       </div>
                       <div class="error_message telefono format">
                        <label>Este campo debe contener solo números</label>
                       </div>
                  </div>
                  <div class="field email">
                       <div class="column denominacion">
                            <label>E-mail</label>
                       </div>
                       <div class="column valor">
                            <input type="text" class="input email" name="email">
                       </div>
                       <div class="error_message email">
                        <label>Este campo es obligatorio</label>
                       </div>
                       <div class="error_message format">
                        <label>Debe ingresar una dirección de correo válida</label>
                       </div>
                  </div>
              </div>
          </div>        
     </div>
     <div class="area ambitos">
          <div class="titulo_area">
               <label>RESERVA DE AMBITOS</label>
          </div>
          <div class="area_content">
              <div class="ambito taller">
                <input type="hidden" class="nombre_ambito" value="taller">
                <div class="titulo_ambito">
                    <div class="column checkbox"><input type="checkbox"></div>
                    <div class="column text"><label>Taller</label></div>
                </div>
                <div class="area_desplegable">
                    <div class="leyenda">
                        <label>El taller solo se puede reservar por personas, 
                        el horario de atención es de 9 a 16:30, se aceptan ticket canasta.</label>
                    </div>
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
                    <div class="field_set">
                        <div class="titulo_set">
                            <label>Horarios</label>               
                        </div>  
                        <div class="field horario numero_1">
                            <div class="column denominacion">
                                <label>Horario 1</label>
                            </div>
                            <div class="column valor">
                                <label class="day">Fecha</label>
                                <input type="text" name="cdt[shifts][0][day]" class="day" id="day_1">
                                <label class="hour_from">&nbsp;&nbsp;&nbsp;De</label>
                                <select name="taller[shifts][0][hour_from]" class="hour from">
                                    <?php for($i=0;$i<24;$i++) { ?>
                                        <?php
                                            $hora_string= '';
                                            if ($i < 10){$hora_string = '0';}
                                            $hora_string .= $i; 
                                        ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $hora_string; ?>
                                        </option>    
                                    <?php } ?>
                                </select>
                                <label class="hour_to"> a</label>
                                <select name="taller[shifts][0][hour_to]" class="hour to">
                                    <?php for($i=0;$i<24;$i++) { ?>
                                        <?php
                                            $hora_string= '';
                                            if ($i < 10){$hora_string = '0';}
                                            $hora_string .= $i; 
                                        ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $hora_string; ?>
                                        </option>    
                                    <?php } ?>
                                </select>
                                <label>hs</label>
                                &nbsp;&nbsp;&nbsp;<a class="remove_shift">X</a>
                            </div>
                        </div>   
                        <div><input type="button" class="new_shift" value="Nuevo horario"></div>
                    </div>
                </div>
              </div>
              <div class="ambito salon">
                <input type="hidden" class="nombre_ambito" value="salon">
                <div class="titulo_ambito">
                    <div class="column checkbox"><input type="checkbox"></div>
                    <div class="column text"><label>Salón del centro de trabajo</label></div>
                </div>
                <div class="area_desplegable">
                    <div class="leyenda">
                        <label>El salón solo se puede reservar por personas, 
                        el horario de atención es de 9 a 16:30, se aceptan ticket canasta.</label>
                    </div>
                    <div class="field_set">               
                        <div class="field comentario">
                           <div class="column denominacion">
                                <label>Comentarios</label>
                           </div>
                            <div class="column valor">
                                <textarea name="salon[comentario]" cols="40"rows="3"></textarea>
                            </div>
                        </div>
                    </div>    
                    <div class="field_set">
                        <div class="titulo_set">
                            <label>Horarios</label>               
                        </div>  
                        <div class="field horario numero_1">
                            <div class="column denominacion">
                                <label>Horario 1</label>
                            </div>
                            <div class="column valor">
                                <label class="day">Fecha</label>
                                <input type="text" name="cdt[shifts][0][day]" class="day" id="day_1">
                                <label class="hour_from">&nbsp;&nbsp;&nbsp;De</label>
                                <select name="taller[shifts][0][hour_from]" class="hour from">
                                    <?php for($i=0;$i<24;$i++) { ?>
                                        <?php
                                            $hora_string= '';
                                            if ($i < 10){$hora_string = '0';}
                                            $hora_string .= $i; 
                                        ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $hora_string; ?>
                                        </option>    
                                    <?php } ?>
                                </select>
                                <label class="hour_to"> a</label>
                                <select name="taller[shifts][0][hour_to]" class="hour to">
                                    <?php for($i=0;$i<24;$i++) { ?>
                                        <?php
                                            $hora_string= '';
                                            if ($i < 10){$hora_string = '0';}
                                            $hora_string .= $i; 
                                        ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $hora_string; ?>
                                        </option>    
                                    <?php } ?>
                                </select>
                                <label>hs</label>
                                &nbsp;&nbsp;&nbsp;<a class="remove_shift">X</a>
                            </div>
                        </div>   
                        <div><input type="button" class="new_shift" value="Nuevo horario"></div>
                    </div>
                </div>
              </div>
              <div class="ambito multiuso">
                <input type="hidden" class="nombre_ambito" value="multiuso">
                <div class="titulo_ambito">
                    <div class="column checkbox"><input type="checkbox"></div>
                    <div class="column text"><label>Multiuso</label></div>
                </div>
                <div class="area_desplegable">
                    <div class="leyenda">
                        <label>La multiuso solo se puede reservar por personas, 
                        el horario de atención es de 9 a 16:30, se aceptan ticket canasta.</label>
                    </div>
                    <div class="field_set">               
                        <div class="field comentario">
                           <div class="column denominacion">
                                <label>Comentarios</label>
                           </div>
                            <div class="column valor">
                                <textarea name="multiuso[comentario]" cols="40"rows="3"></textarea>
                            </div>
                        </div>
                    </div>    
                    <div class="field_set">
                        <div class="titulo_set">
                            <label>Horarios</label>               
                        </div>  
                        <div class="field horario numero_1">
                            <div class="column denominacion">
                                <label>Horario 1</label>
                            </div>
                            <div class="column valor">
                                <label class="day">Fecha</label>
                                <input type="text" name="cdt[shifts][0][day]" class="day" id="day_1">
                                <label class="hour_from">&nbsp;&nbsp;&nbsp;De</label>
                                <select name="taller[shifts][0][hour_from]" class="hour from">
                                    <?php for($i=0;$i<24;$i++) { ?>
                                        <?php
                                            $hora_string= '';
                                            if ($i < 10){$hora_string = '0';}
                                            $hora_string .= $i; 
                                        ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $hora_string; ?>
                                        </option>    
                                    <?php } ?>
                                </select>
                                <label class="hour_to"> a</label>
                                <select name="taller[shifts][0][hour_to]" class="hour to">
                                    <?php for($i=0;$i<24;$i++) { ?>
                                        <?php
                                            $hora_string= '';
                                            if ($i < 10){$hora_string = '0';}
                                            $hora_string .= $i; 
                                        ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $hora_string; ?>
                                        </option>    
                                    <?php } ?>
                                </select>
                                <label>hs</label>
                                &nbsp;&nbsp;&nbsp;<a class="remove_shift">X</a>
                            </div>
                        </div>   
                        <div><input type="button" class="new_shift" value="Nuevo horario"></div>
                    </div>
                </div>
              </div>
          </div>
     </div>  
     <div class="area alojamiento">
          <div class="titulo_area">
               <label>ALOJAMIENTO</label>
          </div>        
          <div class="area_content">
          </div>
     </div>  
     
     

    <div class="form-row botones">
      <input id="reserva_submit" class="submit" value="Reservar" name="enviar" type="submit" />
    </div>
  </form>
</div>


<?php //a_js_call('lareja.reservaInit()') ?>
<?php a_js_call('lareja.reservaInit(?)', array(
    'test' => $titulo
  )) ?>


