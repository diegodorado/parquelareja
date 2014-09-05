// aOverrides is called from aUI()
// This helps for things like Cufon that need to be setup again after an AJAX call
function aOverrides()
{

}


function larejaConstructor()
{
	this.reservaInit = function(options)
	{
		
		$('#Opciones .opcion.reserva').click(function(){
			$('#Opciones').slideUp();
			$('#Opciones_reserva').slideDown();
		});
		$('#Opciones_reserva .continuar').click(function(){	
			$('#Opciones_reserva .error_message').hide();
			if( $('#Opciones_reserva input:checked').size() > 0 ){
				$('#Opciones_reserva').slideUp(600, function(){
					$('form#form_reserva').slideDown(800);
				});
				initReserva();
			}
			else{
				$('#Opciones_reserva .error_message').show();
			}
		});
		$('#Opciones .opcion.aviso_uso').click(function(){
			$('#Opciones').hide();
			$('form#form_aviso_uso').show();
			initAviso();
		});
        $('.field.particular').hide();
        $('#reserva_organismo').parent().hide();
		
		function initReserva(){
		
			if ( $('#Opciones_reserva input.alojamiento:checked').size() > 0 ){
				$('.area.general .field_set.fecha.taller').hide();
			}
			else{
				$('.area.general .field_set.fecha.alojamiento').hide();
			}
		
			initShifts('taller');
			initGuests('cde');
			initGuests('cdt');
			
			today = new Date();
			$('.field.fecha input').datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange:'-10:+10',
			});
			if ($('.field.fecha.desde input').val() != ""){
				setMinDate($('.field.fecha.desde input'),$('.field.fecha.hasta input'));
				$('.warning_message.fecha').hide();
				if (isPast($('.field.fecha.desde input'))){
					$('.warning_message.fecha').show();
					setSchedulesInWorkshopLegend();
				}
				
			}
			if ($('.field.fecha.hasta input').val() != ""){
				setMaxDate($('.field.fecha.hasta input'),$('.field.fecha.desde input'));
			}
			$('.field.fecha.desde input').change(function(){
				setMinDate($(this),$('.field.fecha.hasta input'));
				$('.warning_message.fecha').hide();
				if (isPast($(this))){
					$('.warning_message.fecha').show();
				}
				setSchedulesInWorkshopLegend();
			});
			$('.field.fecha.hasta input').change(function(){
				setMaxDate($(this),$('.field.fecha.desde input'));
			});
		
		
			$('.ambito .checkbox input').each(function(){
				$ambito = $(this).parent().parent().parent();
				if ($(this).attr('checked')){
					$ambito.find('.area_desplegable').show();
					initAmbito($ambito, true);
				}
			});

			$('.titulo_ambito .checkbox input').click(function(){
				$ambito = $(this).parent().parent().parent();
				if ($(this).attr('checked')){
					$ambito.find('.area_desplegable').show();
					initAmbito($ambito, true);
				}
				else{
					if ($ambito.find('.responsible').size() > 0){
						if ($('.ambito .checkbox input:checked').size() == 0){
							removeResponsible($ambito);
						}
						else{
							moveResponsible($('.ambito .checkbox input:checked:first').parent().parent().parent());
						}
					}
					$ambito.find('.error_message').hide();
					$ambito.find('.area_desplegable').hide();
				}
			});
			
			$('#form_reserva .area.general input.nombre').keyup(function(){
				$('#form_reserva .responsible .guest_name').val( $(this).val() + ' ' + $('#form_reserva input.apellido').val() );
				$('#form_reserva .responsible .guest_name').attr( 'title', $('#form_reserva .responsible .guest_name').val() );
			});
			$('#form_reserva .area.general input.apellido').keyup(function(){
				$('#form_reserva .responsible .guest_name').val( $('#form_reserva input.nombre').val() + ' ' + $(this).val() );
				$('#form_reserva .responsible .guest_name').attr( 'title', $('#form_reserva .responsible .guest_name').val() );
			});
			$('#form_reserva .area.general input.email').keyup(function(){
				$('#form_reserva .responsible .guest_email').val( $(this).val() );
				$('#form_reserva .responsible .guest_email').attr( 'title', $(this).val() );
			});
			
			/*$('#form_reserva input.nombre').change(function(){ $('#form_reserva input.nombre').keyup() });
			$('#form_reserva input.apellido').change(function(){ $('#form_reserva input.apellido').keyup() });
			$('#form_reserva input.email').change(function(){ $('#form_reserva input.email').keyup() });*/
			$('#form_reserva .area.general input.nombre').blur(function(){ $('#form_reserva .area.general input.apellido').keyup() })
			$('#form_reserva .area.general input.apellido').blur(function(){ $('#form_reserva .area.general input.apellido').keyup() });
			$('#form_reserva .area.general input.email').blur(function(){ $('#form_reserva .area.general input.email').keyup() });
			
			$('.ambito .remove_shift').hide();
			$('.ambito .remove_guest').hide();
			
			$('.ambito .new_shift').click(function(){
				$ambito = $(this).parent().parent().parent().parent();
				$nombre = $ambito.find('.nombre_ambito').val();
				$cantidad = $('.field.horario').size();
				$('.ambito.'+$nombre+' .field.horario:last').clone().insertAfter('.ambito.'+$nombre+' .field.horario:last');
				$('.ambito.'+$nombre+' .field.horario a.remove_shift').show();
				initShifts($nombre);
			});
			 
			/*codigo js que es llamado en la vista reserva/templates/indexSuccess.php con <?php a_js_call('lareja.reservaInit()') ?> */
			
			$('.alojamiento .new_guest').click(function(){
				$ambito_name = $(this).parent().parent().parent().parent().find('.nombre_ambito').val();
				$('.ambito.' + $ambito_name + ' .field.guest:last').clone().insertAfter('.ambito.' + $ambito_name + ' .field.guest:last');
				$('.ambito.' + $ambito_name + ' .field.guest:last .guest_name').val('').removeAttr('disabled');
				$('.ambito.' + $ambito_name + ' .field.guest:last .guest_email').val('').removeAttr('disabled');
				$('.ambito.' + $ambito_name + ' .field.guest:last').removeClass('responsible');
				$('.ambito.' + $ambito_name + ' .field.guest:last .error_message').hide();
				initGuests($ambito_name);
			});
			
			$('#reserva_submit').click(function(){
				$('.responsible').size();
			});
			
			init_datos_validation();	
			init_solicitante_select();
			$('.field.solicitante select').change();
		}
		
		function initAlojamientoTaller(){
			$('.general_data .nombre_apellido').html($('.area.general input.nombre').val() + ' ' + $('.area.general input.apellido').val());
			$('.general_data .email').html($('.area.general input.email').val());
			$('.general_data .telefono').html($('.area.general input.telefono').val());
			if ( $('.area.general textarea.comentario').val() != ""){
				$('.general_data .texto.comentario').html($('.area.general textarea.comentario').val());
			}
			else{
				$('.general_data .comentario').hide();
			}
			if ( $('.area.general select.tipo_solicitante').val() == 'organismo' ){
				$('.general_data .tipo').html('(' + $('.area.general select.organismos option:selected').html() + ')');
			}
			else if( $('.area.general select.tipo_solicitante').val() == 'mensaje' ){
				$('.general_data .tipo').html('(' + 'Comunidad ' + $('.area.general input.comunidad').val() + ')');
			}
			else{
				$('.general_data .tipo').html('(' + 'maestro' + ')');
			}
			if ( $('#Opciones_reserva input.alojamiento:checked').size() > 0 ){
				$('.general_data .fecha.desde').html( $('.area.general input.fecha.desde').val() );
				$('.general_data .fecha.hasta').html( $('.area.general input.fecha.hasta').val() );
			}
			else{
				$('.general_data .palabra.desde').html( 'Fecha' );
				$('.general_data .fecha.desde').html( $('.area.general input.fecha.unica').val() );
				$('.general_data .palabra.hasta, .general_data .fecha.hasta').hide();
			}
			
			$titulo = "Reserva - Paso 2: ";
			if($('#Opciones_reserva input.alojamiento:checked').size() > 0){
				$titulo += "Centros";
				$('.area.alojamiento').show();
			}
			if($('#Opciones_reserva input.taller:checked').size() > 0){
				if($('#Opciones_reserva input.alojamiento:checked').size() > 0){
					$titulo += " y ";
				}	
				$titulo += "Taller";
				$('.area.ambitos').show();
			}
			$('.superarea.alojamiento_taller').show();
			$('#form_reserva').slideDown(400);
			$('#form_reserva h3').html($titulo);
			init_alojamiento_validation();
		}
		
		
		function initAmbito($ambito,$setResponsible){
			var debo_acomodar_placeholder=!'placeholder' in document.createElement('input');
			if(debo_acomodar_placeholder){
				asignar_evento(window,'load',acomodar_formularios);
			}
			if ($setResponsible){
				setResponsible($ambito);
			}
			checkForWorkshopLegend();
			if ($ambito.find('.responsible').size() == 0){
				$('.mover_responsable').unbind('click');
				$ambito.find('.titulo_set .mover_responsable').show();
				$('.mover_responsable').click(function(){
					moveResponsible($ambito);
				});
			}
			initGuests($ambito.find('.nombre_ambito').val());
		}
		
        function initShifts($nombre){
            $current_number = 0;
            $('.horario input.day').removeClass('hasDatepicker');
            $('.ambito.'+$nombre+' .field.horario').each(function(){
                $currentHorario = $(this);
                $currentHorario.find('.denominacion').html('Horario ' + ($current_number+1));
                $currentHorario.find('.valor input.day').attr('name', $nombre + '[shifts][' + $current_number + '][day]');
                $currentHorario.find('.valor input.day').attr('id', $nombre + '_' + ($current_number+1) + '_day' );
                $currentHorario.find('.valor input.day').datepicker({changeMonth: true,changeYear: true, yearRange:'-10:+10'});
                $currentHorario.find('.valor select.hour.from').attr('name', $nombre + '[shifts][' + $current_number + '][hour_from]');
                $currentHorario.find('.valor select.hour.to').attr('name', $nombre + '[shifts][' + $current_number + '][hour_to]');
                $currentHorario.removeClass('numero_' + $current_number);
                $currentHorario.addClass('numero_' + ($current_number+1));
                $current_number++;
            });
			$('.ambito .remove_shift').unbind('click');
            $('.ambito .remove_shift').click(function(){
                $ambito = $(this).parent().parent().parent().parent().parent();
                $(this).parent().parent().remove();
                initShifts($nombre);
                if ( $('.ambito.'+$nombre+' .field.horario').size() == 1 ){
                    $('.ambito.'+$nombre+' .field.horario a.remove_shift').hide();
                }
            });
        }
        
		function initGuests($ambito_name){
			$current_number = 0;
            $('.' + $ambito_name + ' input.guest_from').removeClass('hasDatepicker');
            $('.' + $ambito_name + ' input.guest_to').removeClass('hasDatepicker');
			$('.ambito.' + $ambito_name + ' .field.guest').each(function(){
				$(this).find('.denominacion label').html('Alojado ' + ($current_number+1));
				$(this).find('input.guest_name').attr('name','guests['+$ambito_name+']['+$current_number+'][name]');
				$(this).find('input.guest_email').attr('name','guests['+$ambito_name+']['+$current_number+'][email]');
				/*$(this).find('input.guest_from').attr('name','guests['+$ambito_name+']['+$current_number+'][from]');
				$(this).find('input.guest_to').attr('name','guests['+$ambito_name+']['+$current_number+'][to]');
				$(this).find('input.guest_from').attr('id',$ambito_name + '_' + $current_number + '_from');
				$(this).find('input.guest_to').attr('id',$ambito_name + '_' + $current_number + '_to');
				$(this).find('input.guest_from').datepicker({changeMonth: true,changeYear: true, yearRange:'-10:+10'});
				$(this).find('input.guest_to').datepicker({changeMonth: true,changeYear: true, yearRange:'-10:+10'});
				
				if ($(this).find('input.guest_from').val() != ""){
					setMinDate($(this).find('input.guest_from'),$(this).find('input.guest_to'));
				}
				
				if ($(this).find('input.guest_to').val() != ""){
					setMaxDate($(this).find('input.guest_to'),$(this).find('input.guest_from'));
				}
				
				$(this).find('input.guest_from').change(function(){
					setMinDate($(this),$(this).parent().find('input.guest_to'));
				});
				$(this).find('input.guest_to').change(function(){
					setMaxDate($(this),$(this).parent().find('input.guest_from'));
				});*/
				$current_number++;
			});
			
			$titulo = $current_number;
			
			if ($current_number == 1){
				$titulo += ' Alojado';
			}
			else{
				$titulo += ' Alojados';
			}
			
			$('.ambito.' + $ambito_name + ' .titulo_set label' ).html($titulo);
			$('.remove_guest').unbind('click');
            $('.remove_guest').click(function(){
                $(this).parent().parent().remove();
                initGuests($ambito_name);
                if ( $('.ambito.'+$ambito_name+' .field.guest').size() == 1 ){
                    $('.ambito.'+$ambito_name+' .field.guest a.remove_guest').hide();
                }
            });
			
			$('.ambito.' + $ambito_name + ' .remove_guest').hide();
			if ( $('.ambito.' + $ambito_name + ' .field.guest').size() > 1){
				$('.ambito.' + $ambito_name + ' .remove_guest').show();
			}
            $('.ambito.'+$ambito_name+' .field.guest.responsible a.remove_guest').hide();
			$('.ambito.'+$ambito_name+' .responsible .column.denominacion label').html('Responsable');
		}
		
		function initAviso(){
			today = new Date();
			$('.field.fecha input').datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange:'-10:+10',
				minDate: today
			});
			if ( $('.field.fecha input').val() != "" ){
				initHorarioFields();
			}
			$('.field.fecha input').change(function(){
				initHorarioFields();
			});
			init_solicitante_select();
			init_aviso_uso_validation();
		}
		
		function initHorarioFields(){
			
			$.ajax({
				data : {
					date:$('.field.fecha input').val()
				},
				url: "/ajax/getParkSchedules.php",
				type: "POST",
				dataType: "json",
				success: function($data){
					$('.field.horario select').each(function(){
						$(this).html($data.code);
						$('.field.horario select').removeAttr('disabled');
					});
					$('.field.horario select.desde option:last').remove();
					$('.field.horario select.hasta option:first').remove();
				}
			});
		}
		
		function setResponsible($ambito){
			if ($('.responsible').size() == 0){
				$ambito.find('.column.denominacion label').html('Responsable');
				$ambito.find('.field.guest').addClass('responsible');
				$ambito.find('.field.guest input.guest_name').val( $('#form_reserva input.nombre').val() + ' ' + $('#form_reserva input.apellido').val());
				$ambito.find('.field.guest input.guest_name').attr( 'title', $ambito.find('.field.guest input.guest_name').val() );
				$ambito.find('.field.guest input.guest_name').attr('disabled','disabled');
				$ambito.find('.field.guest input.guest_email').val( $('#form_reserva input.email').val() );
				$ambito.find('.field.guest input.guest_email').attr( 'title', $ambito.find('.field.guest input.guest_email').val() 	 );
				$ambito.find('.field.guest input.guest_email').attr('disabled','disabled');
			}
			$ambito.find('.mover_responsable').hide();
		}
		
		function moveResponsible($ambito){
			$ambito_anterior = $('#form_reserva .responsible').parent().parent().parent();
			
			$('#form_reserva .responsible').clone().insertBefore( $ambito.find('.field.guest:first') );
			$ambito.find('.mover_responsable').hide();
			
			removeResponsible($ambito_anterior);
				
			initGuests( $ambito.find('.nombre_ambito').val() );
			initGuests( $ambito_anterior.find('.nombre_ambito').val() );
		}
		
		function removeResponsible($ambito){
			if ($ambito.find('.field.guest').size() == 1){
				$ambito.find('.field.guest').removeClass('responsible');
				$ambito.find('.field.guest input').removeAttr('disabled');
				$ambito.find('.field.guest input').val('');
			}
			else{
				$ambito.find('.field.guest.responsible').remove();
			}
			initAmbito($ambito, false);
		}
		
		function setSchedulesInWorkshopLegend(){
			$.ajax({
				data : {
					date:$('.field.fecha.desde input').val()
				},
				url: "/ajax/getParkSchedules.php",
				type: "POST",
				dataType: "json",
				success: function($data){
					$('span.openingTime').html($data.open);
					$('span.closingTime').html($data.close);
				}
			});
		}
		
		function checkForWorkshopLegend(){
			if ($('.area.alojamiento .ambito .checkbox input:checked').size() > 0){
				$('.taller .leyenda').hide();
			}
			else{
				$('.taller .leyenda').show();
			}
		}
		function init_aviso_uso_validation(){
			$('#aviso_uso_submit').click(function(){
				$('.error_message').hide();
				$all_ok = true;

				
				$('form#form_aviso_uso .input.required:visible').each(function(){
					if ( $(this).val() == "" ){
						$all_ok = false;
						$(this).parent().find('.error_message.required').show();
					}
				});
				
				$('form#form_aviso_uso .input.email:visible').each(function(){
					var reg = new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
					if ( $(this).val() != "" && !reg.test($(this).val())){
						$all_ok = false;
						$(this).parent().find('.error_message.format').show();
					}
				});
				
				$('form#form_aviso_uso .input.number:visible').each(function(){
					var reg = new RegExp(/^\s*\d+\s*$/);
					if ( $(this).val() != "" && !reg.test($(this).val())){
						$all_ok = false;
						$(this).parent().find('.error_message.number').show();
					}
				});
				
				$desde = parseInt($('form#form_aviso_uso .input.horario.desde:visible').val());
				$hasta = parseInt($('form#form_aviso_uso .input.horario.hasta:visible').val());
				if (!($hasta > $desde)){
					$all_ok = false;
					$('.field.horario .error_message.horario').show();
				};
								
				if($all_ok){
					$('#form_aviso_uso div:hidden input,div:hidden select,div:hidden textarea').removeAttr('name');
					$('#form_aviso_uso').submit();
				}				
			});
		}

	function init_datos_validation(){
		$('.area.general .boton.continuar').click(function(){
			$all_ok = true;
			$('.area.general .error_message').hide();
						
			$('.area.general input.required:visible').each(function(){
				if ( $(this).val() == "" ){
					$all_ok = false;
					$(this).parent().find('.error_message.required').show();
				}
			});
			$('.area.general input.email:visible').each(function(){
				if ($(this).val != ""){
					$re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if (!$re.test($(this).val())){
						$all_ok = false;
						$(this).parent().find('.error_message.email.format').show();
					}
				}
			});
			if($all_ok){
				$('#form_reserva').slideUp(400, function(){
					$('.area.general').hide();
					initAlojamientoTaller();
				});
			}
		});
	}
	function init_alojamiento_validation(){
		$('.superarea.alojamiento_taller .boton.continuar').click(function(){
			$all_ok = true;
			$('.superarea.alojamiento_taller .error_message').hide();
			
			if ($('#Opciones_reserva input.alojamiento:checked').size() > 0){
				$none_checked = true;
				$('.titulo_ambito .checkbox input').each(function(){
					if ($(this).attr('checked')){
						$none_checked = false;
						$all_complete = true;
						$ambito = $(this).parent().parent().parent();
						$ambito.find('input.required').each(function(){
							if ($(this).val() == ""){
								$all_complete = false;
								$(this).parent().find('.error_message.required').show();
							}
						});
						$ambito.find('input.email:visible').each(function(){
							if ($(this).val() != ""){
								$re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
								if (!$re.test($(this).val())){
									$all_ok = false;
									$(this).parent().find('.error_message.email.format').show();
								}
							}
						});
						if (!$all_complete){
							$all_ok = false;
							$ambito.find('.error_message.lodging').show();
						}
					}
				});			
				if ($none_checked){
					$all_ok = false;
					$('.error_message.lodging_area').show();
				}
			}
			
			if ($('#Opciones_reserva input.taller:checked').size() > 0){
				if ($('.taller .field.actividad input:checked').size() == 0){
					$all_ok = false;
					$('.taller .field.actividad .error_message.required').show();
				}
				if ($('.taller .field.actividad input:checked').size() == 0){
					$all_ok = false;
					$('.taller .field.actividad .error_message.required').show();
				}
				$('.taller input.required').each(function(){
					if ($(this).val() == ""){
						$all_ok = false;
						$(this).parent().find('.error_message.required').show();
					}
				});
			}	
			if ($all_ok){
				$('#form_reserva .superarea.alojamiento_taller div:hidden input').removeAttr('name');
				$('#form_reserva .superarea.alojamiento_taller div:hidden select').removeAttr('name');
				$('#form_reserva .superarea.alojamiento_taller div:hidden textarea').removeAttr('name');
				//captcha_check();
				$('#form_reserva .guest.responsible input').removeAttr('disabled');
				$('#form_reserva').submit();
			}
		});
	}
			
	function captcha_check(){
		$privatekey = "6LeV7fISAAAAAMMubxtHpWLHvWLXe6Z6O5gfxjrJ";
		$remoteip	= $('#remoteip').val();
		$challenge  = $('#recaptcha_challenge_field').val();
		$response   = $('#recaptcha_response_field').val();
		$.ajax({
			data : {
				privatekey	:$privatekey,
				remoteip	:$remoteip,
				challenge	:$challenge,
				response	:$response
			},
			url: "http://api.recaptcha.net/recaptcha/api",
			type: "POST",
			dataType: "json",
			success: function($data){
				alert($data);
			}
		});
	}		
			
	function init_solicitante_select(){
		switch($('.field.solicitante select').val()){
			case 'organismo':
				$('.field.particular.organismo').show();
			break;
			case 'mensaje':
				$('.field.particular.comunidad').show();
			break;
		}
		
		$('.field.solicitante select').change( function(){
			$('.field.particular').hide();
			switch(this.value) {
				case 'organismo':
					$('.field.particular.organismo').show();
				break;
				case 'mensaje':
					$('.field.particular.comunidad').show();
				break;
			}
		});
	}
	
	function setMinDate($dateElement1,$dateElement2){
		$splitted_date 	= $dateElement1.val().split('/');
		$day 			= $splitted_date[0];
		$month 			= $splitted_date[1];
		$year 			= $splitted_date[2];
		$date			= new Date($year,$month-1,parseInt($day)+1,0,0,0,0);
		$time			= $date.getTime();
		//$nextDayTime    = $time + (1 * 60 * 60 * 24 * 1000);
		//En lugar del proximo día se utiliza el mismo porque si se reserva taller sin alojamiento se ingresa y egresa el mismo día
		$minDate		= new Date($time);
		$dateElement2.datepicker('option','minDate',$minDate);
	}
	
	function setMaxDate($dateElement1,$dateElement2){
		$splitted_date 	= $dateElement1.val().split('/');
		$day 			= $splitted_date[0];
		$month 			= $splitted_date[1];
		$year 			= $splitted_date[2];
		$date			= new Date($year,$month-1,parseInt($day)-1,0,0,0,0);
		$time			= $date.getTime();
		//$nextDayTime    = $time - (1 * 60 * 60 * 24 * 1000);
		//En lugar del día anterior se utiliza el mismo porque si se reserva taller sin alojamiento se ingresa y egresa el mismo día
		$maxDate		= new Date($time);
		$dateElement2.datepicker('option','maxDate',$maxDate);
	}
	
	function isPast($dateElement1){
		$splitted_date 	= $dateElement1.val().split('/');
		$day 			= $splitted_date[0];
		$month 			= $splitted_date[1];
		$year 			= $splitted_date[2];
		$date			= new Date($year,$month-1,$day,0,0,0,0);
		$dateTime		= $date.getTime();
		$today			= new Date();
		$todayTime		= $today.getTime();
		$difference		= $date - $today; 
		if ( ($difference/1000/60/60) < -24){
			return true;
		}
		return false;
	}
	
	this.calendarInit = function(options)
	{
		$('#calendar_filters h5').click(function(e){
			console.log(this);
  		$('#calendar_filters h5').removeClass('selected');
  		$(this).addClass('selected');
  		$('#calendar').attr('class','');
  		$('#calendar').addClass($(this).attr('data-type'));
		});
	
	};




	this.embedSWF = function(options){
		var id = options['id'];
		var swf = options['swf'];
		var $el = $('#'+id);
		var w = (options['width'])?options['width']:$el.width();
		var h = (options['height'])?options['height']:$el.height();
		swfobject.embedSWF(swf, id, w, h, "9.0.0");
	};
	
	function emular_placeholder(evento){
		if(!this.getAttribute('hube_entrado')){
			this.value='';
			this.setAttribute('hube_entrado','si');
			this.style.color='black';
		}
	}
	function asignar_evento(destino,nombre_evento,funcion){
		if(destino.addEventListener){
			destino.addEventListener(nombre_evento,funcion);
		}else{
			destino['on'+nombre_evento]=funcion;
		}
	}
	function acomodar_un_formulario(formulario){
	  var inputs_a_transformar={};
	  for(var i=0; i<formulario.children.length; i++){
		var elemento=formulario.children[i];
		if(elemento.tagName=='INPUT'){
		  var texto_placeholder=elemento.getAttribute('placeholder');
		  if(texto_placeholder){
			elemento.value=texto_placeholder;
			elemento.style.color='#787878';
			asignar_evento(elemento,'focus',emular_placeholder);
		  }
		}
	  }
	}
	function acomodar_formularios(){
		for(var i=0; i<document.forms.length; i++){
			acomodar_un_formulario(document.forms[i]);
		}
	}
	
}

}

window.lareja = new larejaConstructor();

