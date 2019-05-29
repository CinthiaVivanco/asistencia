$(document).ready(function() {

    $("#dni").focus();
    var carpeta = $("#carpeta").val();
    $('#dni').on('keypress', function (e) {


         if(e.which === 13){

            var _token          = $('#token').val();
            var puntero         = $(this);
            var dni             = $("#dni").val();

            if(dni.length != 8){
                alerterrorajax("DNI tiene que ser 8 digitos");
                return false;
            }
            abrircargandomarcacion();

            $.ajax({
                type    :   "POST",
                url     :   carpeta+"/ajax-marcar-asistencia",
                data    :   {
                                _token          : _token,
                                dni             : dni                                              
                            },
                success: function (data) {
                    cerrarcargando();
                    $('#ajaxmensaje').html(data);
                    $("#dni").val('');
                    $("#dni").focus();
                    setTimeout(function(){ $(".datos").fadeOut(1000).fadeIn(200).fadeOut(400).fadeIn(400).fadeOut(100);}, 1500);

                },
                error: function (data) {
                    if(data.status = 500){
                        var contenido = $(data.responseText);
                        alerterror505ajax($(contenido).find('.trace-message').html()); 
                        console.log($(contenido).find('.trace-message').html());     
                    }
                }
            });


         }
   });


    $(".validarnumero").keydown(function(event){

        if(event.keyCode == 13 || event.keyCode == 116){
            return true;
        }
        if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !==190  && event.keyCode !==110 && event.keyCode !==8 && event.keyCode !==9  ){
            return false;
        }


    });

    setInterval( function() {
    var seconds = new Date().getSeconds();
    var sdegree = seconds * 6;
    var srotate = "rotate(" + sdegree + "deg)";
    
    $("#sec").css({"-moz-transform" : srotate, "-webkit-transform" : srotate});
        
    }, 1000 );
    

    setInterval( function() {
    var hours = new Date().getHours();
    var mins = new Date().getMinutes();
    var hdegree = hours * 30 + (mins / 2);
    var hrotate = "rotate(" + hdegree + "deg)";
    
    $("#hour").css({"-moz-transform" : hrotate, "-webkit-transform" : hrotate});
        
    }, 1000 );


    setInterval( function() {
    var mins = new Date().getMinutes();
    var mdegree = mins * 6;
    var mrotate = "rotate(" + mdegree + "deg)";
    
    $("#min").css({"-moz-transform" : mrotate, "-webkit-transform" : mrotate});
        
    }, 1000 );
 
}); 

