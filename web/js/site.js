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
        
        $('.ambito .checkbox input').click(function(){
            $ambito = $(this).parent().parent().parent();
            if ($(this).attr('checked')){
                $ambito.find('.area_desplegable').show();
            }
            else{
                $ambito.find('.area_desplegable').hide();              
            }
        });
        
        $('.ambito .remove_shift').hide();
        
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
            $('.ambito .remove_shift').click(function(){
                $ambito = $(this).parent().parent().parent().parent().parent();
                $(this).parent().parent().remove();
                initShifts($nombre);
                if ( $('.ambito.'+$nombre+' .field.horario').size() == 1 ){
                    $('.ambito.'+$nombre+' .field.horario a.remove_shift').hide();
                }
            });
        }
        
        
        initShifts('taller');
        initShifts('salon');
        initShifts('multiuso');
    
        $('.ambito .checkbox input').each(function(){
        
            $ambito = $(this).parent().parent().parent();
            if ($(this).attr('checked')){
                $ambito.find('.area_desplegable').show();
            }
            else{
                $ambito.find('.area_desplegable').hide();              
            }
        });
        
         
		/*codigo js que es llamado en la vista reserva/templates/indexSuccess.php con <?php a_js_call('lareja.reservaInit()') ?> */


	};
	
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
	
	
	
	
}

window.lareja = new larejaConstructor();

