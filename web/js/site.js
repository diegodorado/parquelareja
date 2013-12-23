// aOverrides is called from aUI()
// This helps for things like Cufon that need to be setup again after an AJAX call
function aOverrides()
{

}


function larejaConstructor()
{
	this.reservaInit = function(options)
	{
    $('#reserva_comunidad').parent().hide();
    $('#reserva_organismo').parent().hide();
    $('#reserva_solicitante').change( function(){
        $('#reserva_comunidad').parent().hide();
        $('#reserva_organismo').parent().hide();
        $('#reserva_nombre').parent().hide();
        switch(this.value) {
          case 'organismo':
            $('#reserva_organismo').parent().show();
            break;
          case 'comunidad':
            $('#reserva_comunidad').parent().show();
            break;
          case 'maestro':
            $('#reserva_nombre').parent().show();
            break;
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

