$(document).ready(function(){
    var carpeta = $("#carpeta").val();


    $('#buscardiasxperiodo').on('click', function(event){

        var _token              = $('#token').val();
        var periodo_id           = $('#periodo_id').val();     

        if(periodo_id.length<=0){
            alerterrorajax("Seleccione una periodo");
            return false;
        }

        $(".listadiasxperiodo").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-dias-periodo",
            data    :   {
                            _token          : _token,
                            periodo_id      : periodo_id,                            
                        },
            success: function (data) {

                $(".listadiasxperiodo").html(data);                
            },
            error: function (data) {

                cerrarcargando();

                if(data.status = 500){
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listadiasxperiodo").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    });

});