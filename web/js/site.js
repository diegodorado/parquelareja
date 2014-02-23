// aOverrides is called from aUI()
// This helps for things like Cufon that need to be setup again after an AJAX call
function aOverrides()
{

}


function larejaConstructor()
{
	this.reservaInit = function(options)
	{
	
        $('.field.particular').hide();
        $('#reserva_organismo').parent().hide();
		
        initShifts('taller');
        initShifts('salon');
        initShifts('multiuso');
		initGuests('cde');
		initGuests('cdt');		
        $('.ambito .checkbox input').each(function(){
            $ambito = $(this).parent().parent().parent();
            if ($(this).attr('checked')){
                $ambito.find('.area_desplegable').show();
            }
            else{
                $ambito.find('.area_desplegable').hide();              
            }
        });
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
        
        $('.titulo_ambito .checkbox input').click(function(){
            $ambito = $(this).parent().parent().parent();
            if ($(this).attr('checked')){
                $ambito.find('.area_desplegable').show();
            }
            else{
                $ambito.find('.area_desplegable').hide();              
            }
        });
        
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
        
        
        
         
		/*codigo js que es llamado en la vista reserva/templates/indexSuccess.php con <?php a_js_call('lareja.reservaInit()') ?> */


		
		$('.alojamiento .new_guest').click(function(){
			$ambito_name = $(this).parent().parent().parent().parent().find('.nombre_ambito').val();
			$('.ambito.' + $ambito_name + ' .field.guest:last').clone().insertAfter('.ambito.' + $ambito_name + ' .field.guest:last');
			$('.ambito.' + $ambito_name + ' .field.guest:last .guest_name').val('');
			$('.ambito.' + $ambito_name + ' .remove_guest').show();
			initGuests($ambito_name);
		});
		
		function initGuests($ambito_name){
			$current_number = 0;
            $('.' + $ambito_name + ' input.guest_from').removeClass('hasDatepicker');
            $('.' + $ambito_name + ' input.guest_to').removeClass('hasDatepicker');
			$('.ambito.' + $ambito_name + ' .field.guest').each(function(){
				$(this).find('.denominacion label').html('Huesped ' + ($current_number+1));
				$(this).find('input.guest_name').attr('name','guests['+$ambito_name+']['+$current_number+'][name]');
				$(this).find('input.guest_from').attr('name','guests['+$ambito_name+']['+$current_number+'][from]');
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
				});
				$current_number++;
			});
			
			$titulo = $current_number;
			
			if ($current_number == 1){
				$titulo += ' Huesped';
			}
			else{
				$titulo += ' Huéspedes';
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
		}
	};
	
	function setMinDate($dateElement1,$dateElement2){
		$splitted_date 	= $dateElement1.val().split('/');
		$day 			= $splitted_date[0];
		$month 			= $splitted_date[1];
		$year 			= $splitted_date[2];
		$date			= new Date($year,$month-1,$day,0,0,0,0);
		$time			= $date.getTime();
		$nextDayTime    = $time + (1 * 60 * 60 * 24 * 1000);
		$nextDay		= new Date($nextDayTime);
		$dateElement2.datepicker('option','minDate',$nextDay);
	}
	
	function setMaxDate($dateElement1,$dateElement2){
		$splitted_date 	= $dateElement1.val().split('/');
		$day 			= $splitted_date[0];
		$month 			= $splitted_date[1];
		$year 			= $splitted_date[2];
		$date			= new Date($year,$month-1,$day,0,0,0,0);
		$time			= $date.getTime();
		$nextDayTime    = $time - (1 * 60 * 60 * 24 * 1000);
		$nextDay		= new Date($nextDayTime);
		$dateElement2.datepicker('option','maxDate',$nextDay);
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




	this.embedSWF = function(options)
	{
		var id = options['id'];
		var swf = options['swf'];
		var $el = $('#'+id);
		var w = (options['width'])?options['width']:$el.width();
		var h = (options['height'])?options['height']:$el.height();
		swfobject.embedSWF(swf, id, w, h, "9.0.0");
	};
	
	this.validate = function(){
	
		
		$('#reserva_submit').click(function(){
			
			$('.error_message').hide();
			$all_ok = true;
			
			$('.area.general input.required:visible').each(function(){
				if ( $(this).val() == "" ){
					$all_ok = false;
					$(this).parent().find('.error_message.required').show();
				}
			});
			if ($('input.email').val() != ""){
				$re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if (!$re.test($('input.email').val())){
					$all_ok = false;
					$('.error_message.email.format').show();
				}
			}
			if ($all_ok){
				$none_checked = true;
				$('.titulo_ambito .checkbox input').each(function(){
					if ($(this).attr('checked')){
						$none_checked = false;
						$all_complete = true;
						$ambito = $(this).parent().parent().parent();
						$ambito.find('input.required').each(function(){
							if ($(this).val() == ""){
								$all_complete = false;
								$ambito.find('.error_message.date').show();
							}
						});
						$ambito.find('select.hour.from').each(function(){
							$fromValue = parseInt($(this).val());
							$toValue   = parseInt($(this).parent().find('.hour.to').val());
							if (!($toValue>$fromValue)){
								$all_complete = false;
								$ambito.find('.error_message.time').show();
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
					$('.error_message.nada_reservado').show();
				}
			}
			if($all_ok){
				//alert('submit');
				$('div:hidden input,div:hidden select,div:hidden textarea').removeAttr('name');
				$('#form_reserva').submit();
			}
		});
	
	}
	
	
}

window.lareja = new larejaConstructor();

