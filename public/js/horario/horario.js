$(document).ready(function(){


    var carpeta = $("#carpeta").val();
    var numero = $('.clockactivo').attr("data");

    jQuery('.scrollbar-inner').scrollbar();
    jQuery('.scrollbar-inner').scrollTop(numero*25);

    $(".ajaxtrabajador").on('click','#agregartrabajadorhorario', function() {


        var _token          = $('#token').val();
        var puntero         = $(this);
        var trabajador_id   = $("#trabajador_id").val();
        var semana_id       = $(this).attr('data_semana');
        var idsede          = $("#sede_id").val();


        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador");
            return false;
        }

        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-alta-trabajador-horario",
            data    :   {
                            _token          : _token,
                            trabajador_id   : trabajador_id,
                            semana_id       : semana_id, 
                            idsede          : idsede                                                     
                        },
            success: function (data) {

                cargarhorario(idsemana,idsede);
                
            },
            error: function (data) {
                if(data.status = 500){
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    }); 
    







    $(".listadohorario").on('click','#bajatrabajadorhorario', function() {

        var _token          = $('#token').val();
        var puntero         = $(this);
        var idhorario       = $(this).attr('data-id');
        var estado          = $(this).attr('data-estado');

        if(estado == '0'){ 
            estado = '1'; seleccion = ''; mostraocultar = 'mostrarbajatd';trabajadorbaja = '';
        }else{ 
            estado = '0';  mostraocultar = 'ocultarbaja';seleccion = 'seleccion';trabajadorbaja = 'trabajadorbaja';
        }

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-baja-trabajador-horario",
            data    :   {
                            _token          : _token,
                            idhorario       : idhorario,
                            estado          : estado,                           
                        },
            success: function (data) {

                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;


                if(error==false){

                    alertajax(mensaje);
                    $(puntero).removeClass('seleccion');
                    $(puntero).parents('.datostrabajador').removeClass('trabajadorbaja');
                    $(puntero).parents('.datostrabajador').siblings('td').removeClass('mostrarbajatd');
                    $(puntero).parents('.datostrabajador').siblings('td').removeClass('ocultarbaja');

                    $(puntero).parents('.datostrabajador').addClass(trabajadorbaja);
                    $(puntero).parents('.datostrabajador').siblings('td').addClass(mostraocultar);
                    $(puntero).addClass(seleccion);
                    $(puntero).attr("data-estado",estado);



                    
                }else{
                    alerterrorajax(mensaje);
                    
                }
                
            },
            error: function (data) {
                if(data.status = 500){

                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

        
    }); 


    $(".ajaxhoraasistencia").on('click','#limpiarhora', function() {

        var inputime   = $(this).parent('.input-group-btn').siblings('.time_pick').find('#timepicker');
        inputime.val('');
        
    });    


    $(".listadohorario").on('click','#btnhoraasitencia', function() {

        var _token          = $('#token').val();
       
        var idasistencia    = $(this).attr('data-id');
        var idtrabajador    = $(this).attr('data-tid');        
        var sectorupdate    = $(this).attr('data-ajax');
        var dia             = $(this).attr('data-dia');       
        var fecha           = $(this).attr('data-fecha'); 

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-asistencia-trabajador",
            data    :   {
                            _token          : _token,
                            idasistencia    : idasistencia,
                            idtrabajador    : idtrabajador,
                            sectorupdate    : sectorupdate,
                            dia             : dia,
                            fecha           : fecha        
                        },
            success: function (data) {
                $(".ajaxhoraasistencia").html(data);
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });



    });    


    $(".ajaxhoraasistencia").on('click','#eliminarhora', function() {
        
        var _token          = $('#token').val();     
        var inputime        = $(this).parent('.input-group-btn').siblings('.time_pick').find('#timepicker');
        var hora            = inputime.val();        
        var idasistencia    = $(this).attr('data-id');
        var idtrabajador    = $(this).attr('data-tid');        
        var attractualizar  = $(this).attr('data-atr');
        var dia             = $(this).attr('data-dia');
        var attrdiafecha    = $(this).attr('data-hor');        
        var fecha           = $(this).attr('data-fecha');       
        var entrada         = $(this).attr('data-entrada');
        var cantmarc        = $(this).attr('data-cantmar');
        var aviso           = $(this).attr('data-aviso');        
        var titulo          = $(this).attr('data-titulo');
        var sectorajax      = $(this).attr('data-ajax');
        var attrhorario     = $(this).attr('data-horario');  

        if ($('#'+titulo).hasClass("color-marco") == false) {
            alerterrorajax("No tiene registro no se puede eliminar");
            return false;            
        }


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-eliminar-asistencia-trabajador",
            data    :   {
                            _token          : _token,
                            hora            : hora,
                            idasistencia    : idasistencia,
                            idtrabajador    : idtrabajador,
                            attractualizar  : attractualizar,
                            dia             : dia,
                            attrdiafecha    : attrdiafecha,
                            fecha           : fecha,
                            entrada         : entrada,
                            cantmarc        : cantmarc,                            
                            aviso           : aviso, 
                            attrhorario     : attrhorario,                                                                                         
                        },
            success: function (data) {


                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;

                if(error==false){
                    alertajax(mensaje);
                    $('#'+titulo).removeClass("color-marco");
                    $(inputime).attr("data-val", '');
                    $(inputime).val('');
                    actualizartablaasistencia(sectorajax,idasistencia,dia);
                }else{
                    alerterrorajax(mensaje);
                    inputime.val(inputime.attr('data-val'));
                }
                
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });     
    });



    $(".ajaxhoraasistencia").on('click','#actualizarhora', function() {
        
        var _token          = $('#token').val();       
        var inputime        = $(this).parent('.input-group-btn').siblings('.time_pick').find('#timepicker');
        var hora            = inputime.val();        
        var idasistencia    = $(this).attr('data-id');
        var idtrabajador    = $(this).attr('data-tid');        
        var attractualizar  = $(this).attr('data-atr');
        var dia             = $(this).attr('data-dia');
        var attrdiafecha    = $(this).attr('data-hor');        
        var fecha           = $(this).attr('data-fecha');       
        var entrada         = $(this).attr('data-entrada');
        var cantmarc        = $(this).attr('data-cantmar');
        var aviso           = $(this).attr('data-aviso');        
        var titulo          = $(this).attr('data-titulo');
        var sectorajax      = $(this).attr('data-ajax');
        var attrhorario     = $(this).attr('data-horario');        

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-actualizar-asistencia-trabajador",
            data    :   {
                            _token          : _token,
                            hora            : hora,
                            idasistencia    : idasistencia,
                            idtrabajador    : idtrabajador,
                            attractualizar  : attractualizar,
                            dia             : dia,
                            attrdiafecha    : attrdiafecha,
                            fecha           : fecha,
                            entrada         : entrada,
                            cantmarc        : cantmarc,                            
                            aviso           : aviso, 
                            attrhorario     : attrhorario,                                                                                         
                        },
            success: function (data) {


                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;

                if(error==false){
                    alertajax(mensaje);
                    $('#'+titulo).addClass('color-marco');
                    $(inputime).attr("data-val", hora);
                    actualizartablaasistencia(sectorajax,idasistencia,dia);
                }else{
                    alerterrorajax(mensaje);
                    inputime.val(inputime.attr('data-val'));
                }
                
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });     
    });    


    function actualizartablaasistencia(sectorajax,idasistencia,dia){
        var _token  = $('#token').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-actualizar-tabla-asistencia",
            data    :   {
                            _token          : _token,
                            idasistencia    : idasistencia,
                            dia             : dia                                                              
                        },
            success: function (data) {
                $('#'+sectorajax).html(data);
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        }); 

    }



    $(".listadohorario").on('click','.vacadesc', function() {

        var _token          = $('#token').val();
        var idhorario       = $(this).attr('data-id');
        var estado          = $(this).attr('data-estado');
        var dia             = $(this).attr('data-attr');
        var fecha           = $(this).attr('data-horario'); 
        var estado_btn      = $(this).parent('.buttons').attr('data-estado_btn'); 
        var activo_btn      = $(this).attr('data-activo-btn'); 
        var input           = $(this);
        var seleccion       = ''
        if(activo_btn == '0'){ activo_btn = '1'; seleccion = 'seleccion'; }else{ activo_btn = '0'; }


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-vacaciones-descanso-horario-trabajador",
            data    :   {
                            _token          : _token,
                            idhorario       : idhorario,
                            estado          : estado,
                            estado_btn      : estado_btn,
                            dia             : dia,
                            fecha           : fecha,
                            activo_btn      : activo_btn,
                            
                        },
            success: function (data) {

                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;


                if(error==false){

                    alertajax(mensaje);
                    $(input).parent('.buttons').siblings('.be-checkbox').find('input').prop('checked', false);
                    $(input).parent('.buttons').find('button').removeClass("seleccion");
                    $(input).parent('.buttons').find('button').attr("data-activo-btn", 0);
                    $(input).parent('.buttons').attr("data-estado_btn", "1");


                    $(input).attr("data-activo-btn", activo_btn);
                    $(input).addClass(seleccion);
                    
                }else{
                    alerterrorajax(mensaje);
                    $(input).prop('checked', estado_original);
                }
                
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

        
    });   


    $(".panelhorario").on('change','#empresa_id', function() {

   
        $('#thorario').DataTable().column(0).search(
            $('#empresa_id').val(),
        ).draw();

        var _token              = $('#token').val();
        var empresa             = $('#empresa_id').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-area-empresa",
            data    :   {
                            _token   : _token,
                            empresa  : empresa
                        },
            success: function (data) {
                $(".ajaxarea").html(data);
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    });

    $(".panelhorario").on('change','#area_id', function() {
        $('#thorario').DataTable().column(1).search(
            $('#area_id').val(),
        ).draw();
    });


    $('#descargarhorario').on('click', function(event){

        var _token              = $('#token').val();
        var objeto = $('.listasemana').find('.active');

        if(objeto.length>0){

            idsemana = $(objeto).find('.selectsemana').attr('id');
            href = $(this).attr('data-href')+'/'+idsemana;
            $(this).prop('href', href);
            return true;

        }else{
            alerterrorajax("Seleccione una semana para el reporte");
            return false;
        }

    });

    $('#copiarhorarioclonar').on('click', function(event){
        event.preventDefault();
        var _token              = $('#token').val();
        var objeto = $('.listasemana').find('.active');


        if(objeto.length>0){

            abrircargando();
                
            idsemana = $(objeto).find('.selectsemana').attr('id');
            var idsede          = $("#sede_id").val();

            $.ajax({
                type    :   "POST",
                url     :   carpeta+"/ajax--copiar-horario-clonado",
                data    :   {
                                _token   : _token,
                                idsemana : idsemana,
                                idsede   : idsede
                            },
                success: function (data) {

                    cerrarcargando();
                    if(isJson(data)){

                        JSONdata     = JSON.parse(data);
                        error        = JSONdata[0].error;
                        mensaje      = JSONdata[0].mensaje;

                        alerterrorajax(mensaje);

                    }else{
                        $(".listadohorario").html("");                        
                        $(".listadohorario").html(data);
                        alertajax("Clonación exitosa"); 
                    }
                   
                },
                error: function (data) {
                    cerrarcargando();
                    if(data.status = 500){
                        /** error 505 **/
                        var contenido = $(data.responseText);
                        alerterror505ajax($(contenido).find('.trace-message').html()); 
                        console.log($(contenido).find('.trace-message').html());     
                    }
                }
            });


        }else{
            alerterrorajax("Seleccione una semana para traspase de clonación");
        }
    }); 




    $('#clonarhorario').on('click', function(event){
        event.preventDefault();
        var _token              = $('#token').val();
        var objeto = $('.listasemana').find('.active');

        if(objeto.length>0){

            abrircargando();
                
            idsemana            = $(objeto).find('.selectsemana').attr('id');
            var idsede          = $("#sede_id").val();

            $.ajax({
                type    :   "POST",
                url     :   carpeta+"/ajax-clonar-horario",
                data    :   {
                                _token   : _token,
                                idsemana : idsemana,
                                idsede   : idsede                                
                            },
                success: function (data) {

                    JSONdata     = JSON.parse(data);
                    error        = JSONdata[0].error;
                    cerrarcargando();

                    if(error==true){
                        alertajax("Clonación exitosa");
                    }
                    
                },
                error: function (data) {
                    cerrarcargando();
                    if(data.status = 500){
                        /** error 505 **/
                        var contenido = $(data.responseText);
                        alerterror505ajax($(contenido).find('.trace-message').html()); 
                        console.log($(contenido).find('.trace-message').html());     
                    }
                }
            });


        }else{
            alerterrorajax("Seleccione una semana para clonarla");
        }
    }); 




    $('.selectsemana').on('click', function(event){

        event.preventDefault();
        var idsemana            = $(this).attr("id");
        var idsede              = $("#sede_id").val();
        $("#lista_semana_id").val(idsemana);

        $(".menu-roles li").removeClass( "active" )
        $(this).parents('li').addClass("active");

        if(idsede==''){
            alerterrorajax("Seleccione una sede");
        }else{
            cargarhorario(idsemana,idsede);
        }


    }); 


    $(".panelhorario").on('change','#sede_id', function() {

        var idsemana            = $('#lista_semana_id').val();
        var idsede              = $(this).val();

        if(idsemana==''){
            alerterrorajax("Seleccione una semana");
        }else{
            cargarhorario(idsemana,idsede);
        }


    });

    function cargarhorario(idsemana,idsede){

        var _token              = $('#token').val();

        $(".listadohorario").html("");

        abrircargando();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-listado-de-horario",
            data    :   {
                            _token   : _token,
                            idsemana : idsemana,
                            idsede : idsede                            
                        },
            success: function (data) {
                //console.log(data);
                $("#empresa_id").val("").change();
                $(".listadohorario").html(data);
                ajaxlistatrabajadores(idsemana,idsede);
                cerrarcargando();
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
                cerrarcargando();
            }
        });

    }

    function ajaxlistatrabajadores(idsemana,idsede){


        var _token              = $('#token').val();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-listado-trabajadores-horario",
            data    :   {
                            _token   : _token,
                            idsemana : idsemana,
                            idsede   : idsede                            
                        },
            success: function (data) {
                //console.log(data);
                $(".ajaxtrabajador").html(data);

            },
            error: function (data) {
                if(data.status = 500){

                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
                cerrarcargando();
            }
        });

    }



    $(".panelhorario").on('change','#sede_asistencia_id', function() {

        var idsemana            = $('#lista_semana_id').val();
        var idsede              = $(this).val();

        if(idsemana==''){
            alerterrorajax("Seleccione una semana");
        }else{
            cargarhorarioasistencia(idsemana,idsede);
        }


    });



    $('.selectsemanaasistencia').on('click', function(event){


        event.preventDefault();
        var idsemana            = $(this).attr("id");
        var idsede              = $("#sede_asistencia_id").val();
        $("#lista_semana_id").val(idsemana);

        $(".menu-roles li").removeClass( "active" )
        $(this).parents('li').addClass("active");

        if(idsede==''){
            alerterrorajax("Seleccione una sede");
        }else{
            cargarhorarioasistencia(idsemana,idsede);
        }

    }); 


    function cargarhorarioasistencia(idsemana,idsede){

        var _token              = $('#token').val();

        $(".listadohorario").html("");

        abrircargando();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-listado-de-horario-asistencia",
            data    :   {
                            _token   : _token,
                            idsemana : idsemana,
                            idsede   : idsede                            
                        },
            success: function (data) {
                //console.log(data);
                $("#empresa_id").val("").change();
                $(".listadohorario").html(data);
                cerrarcargando();
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
                cerrarcargando();
            }
        });

    }






    $(".listadohorario").on('click','td label', function() {

        var input   = $(this).siblings('input');
        var accion  = $(this).attr('data-atr');
        var dia     = $(this).attr('data-dia');        
        
        var name    = $(this).attr('name');
        var _token  = $('#token').val()
        var check   = -1;
        var estado  = -1;
        var estado_original  = -1;
        

        if($(input).is(':checked')){ 
            check   = 0;
            estado  = false;
            estado_original  = true;
        }else{
            check = 1;
            estado  = true;
            estado_original  = false;
        }


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-activar-horario-trabajador",
            data    :   {
                            _token  : _token,
                            name    : name,
                            check   : check,
                            accion  : accion,
                            dia     : dia,
                            
                        },
            success: function (data) {

                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;

                if(error==false){
                    alertajax(mensaje);

                }else{
                    alerterrorajax(mensaje);
                    $(input).prop('checked', estado_original);
                }
                
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });
    });    

    var previousValue = "";
    $(".listadohorario").on('focus','#horario_id', function() {
        previousValue = $(this).val();
    });


    $(".listadohorario").on('change','#horario_id', function() {


        var puntero                 = $(this);
        var horario_id              = $(this).val();
        var idhorariotrabajador     = $(this).attr('data-id');
        var atributo                = $(this).attr('data-attr');
        
        var _token                  = $('#token').val();


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-horario-trabajador",
            data    :   {
                            _token              : _token,
                            idhorariotrabajador : idhorariotrabajador,
                            atributo            : atributo,
                            horario_id          : horario_id
                        },
            success: function (data) {


                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;

                if(error==false){
                    hora         = JSONdata[0].hora;
                    $(puntero).parent('.cell-detail').find('.labelhora').html(hora);
                    alertajax(mensaje);                   

                }else{

                    alerterrorajax(mensaje);
                    // select anterior
                    $(puntero).val(previousValue);

                }

            },
            error: function (data) {

                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    });

});