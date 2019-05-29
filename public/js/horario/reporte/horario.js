$(document).ready(function(){
    var carpeta = $("#carpeta").val();


    $('#buscarreporteasistenciaindividualtotal').on('click', function(event){

        var _token              = $('#token').val();
        var empresa_id          = $('#empresa_id').select2().val();
        var sede_id             = $('#sede_id').select2().val();        
        var area_id             = $('#area_id').select2().val();                
        var trabajador_id       = $('#trabajador_id').select2().val();
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 

        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }

        if(empresa_id.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }
        if(area_id.length<=0){
            alerterrorajax("Seleccione un area para el reporte");
            return false;
        }
        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }        

        abrircargando();

        var textoajax   = $('.listaasistenciadiaria').html(); 
        $(".listaasistenciadiaria").html("");



        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-asistencia-individual-total",
            data    :   {
                            _token          : _token,
                            sede_id         : sede_id,
                            empresa_id      : empresa_id,                            
                            area_id         : area_id,                                                        
                            trabajador_id   : trabajador_id,
                            fechainicio     : fechainicio,
                            fechafin        : fechafin
                        },
            success: function (data) {
                cerrarcargando();
                $(".listaasistenciadiaria").html(data);                
            },
            error: function (data) {

                cerrarcargando();
                
                if(data.status = 500){

                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaasistenciadiaria").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });


    $('#descargarasistenciaindividualtotalexcel').on('click', function(event){

        var _token              = $('#token').val();
        var empresa_id          = $('#empresa_id').select2().val();
        var area_id             = $('#area_id').select2().val();                
        var trabajador_id       = $('#trabajador_id').select2().val();
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 
        var sede_id             = $('#sede_id').select2().val(); 
        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }

        if(empresa_id.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }
        if(area_id.length<=0){
            alerterrorajax("Seleccione un area para el reporte");
            return false;
        }
        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }    
        
        href = $(this).attr('data-href')+'/'+sede_id+'/'+empresa_id+'/'+area_id+'/'+trabajador_id+'/'+fechainicio+'/'+fechafin;
        $(this).prop('href', href);
        return true;


    });


    $('#descargarasistenciapilotolexcel').on('click', function(event){

        var _token              = $('#token').val();
        var periodo_id          = $('#periodo_id').select2().val();
        var sede_id             = $('#sede_id').select2().val();

        if(periodo_id.length<=0){
            alerterrorajax("Seleccione una periodo para el reporte");
            return false;
        }

        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }


        href = $(this).attr('data-href')+'/'+periodo_id+'/'+sede_id;
        $(this).prop('href', href);
        return true;

    });


    $(".selectfiltro").on('change','#sede_id', function() {

        var _token              = $('#token').val();
        var sede_id             = $('#sede_id').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-sede-trabajadores-todo",
            data    :   {
                            _token   : _token,
                            sede_id  : sede_id
                        },
            success: function (data) {
                $(".ajaxsede").html(data);
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



    $(".selectfiltro").on('change','#empresa_id', function() {

        var _token              = $('#token').val();
        var empresa             = $('#empresa_id').val();
        var sede_id             = $('#sede_id').val();


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-area-empresa-todo",
            data    :   {
                            _token   : _token,
                            empresa  : empresa,
                            sede_id  : sede_id                            
                        },
            success: function (data) {
                $(".ajaxarea").html(data);
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


    $(".selectfiltro").on('change','#area_id', function() {

        var _token              = $('#token').val();
        var area_id             = $('#area_id').val();
        var empresa_id          = $('#empresa_id').val(); 
        var sede_id             = $('#sede_id').val();


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-trabajador-area-empresa-todo",
            data    :   {
                            _token      : _token,
                            area_id     : area_id,
                            sede_id     : sede_id,                            
                            empresa_id  : empresa_id                         
                        },
            success: function (data) {
                $(".ajaxtrabajador").html(data);
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







    $('#buscarreporteasistenciamensual').on('click', function(event){

        var _token              = $('#token').val();
        var trabajador_id       = $('#trabajador_id').select2().val();
        var sede_id             = $('#sede_id').val();         
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 

        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }

        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }        

        abrircargando();

        var textoajax   = $('.listaasistenciadiaria').html(); 
        $(".listaasistenciadiaria").html("");



        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-asistencia-mensual",
            data    :   {
                            _token          : _token,
                            trabajador_id   : trabajador_id,
                            sede_id         : sede_id,                             
                            fechainicio     : fechainicio,
                            fechafin        : fechafin
                        },
            success: function (data) {
                cerrarcargando();
                $(".listaasistenciadiaria").html(data);                
            },
            error: function (data) {

                cerrarcargando();
                
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaasistenciadiaria").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });


    $('#descargarasistenciamensuallexcel').on('click', function(event){

        var _token              = $('#token').val();
        var trabajador_id       = $('#trabajador_id').select2().val();
        var sede_id             = $('#sede_id').select2().val();       
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 


        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }     

        href = $(this).attr('data-href')+'/'+sede_id+'/'+trabajador_id+'/'+fechainicio+'/'+fechafin; 
        $(this).prop('href', href);
        return true;


    });


    $('#buscarreporteasistenciaindividual').on('click', function(event){

        var _token              = $('#token').val();
        var trabajador_id       = $('#trabajador_id').select2().val();
        var sede_id             = $('#sede_id').val();         
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 


        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }

        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }        

        abrircargando();

        var textoajax   = $('.listaasistenciadiaria').html(); 
        $(".listaasistenciadiaria").html("");



        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-asistencia-individual",
            data    :   {
                            _token          : _token,
                            trabajador_id   : trabajador_id,
                            sede_id         : sede_id,                            
                            fechainicio     : fechainicio,
                            fechafin        : fechafin
                        },
            success: function (data) {
                cerrarcargando();
                $(".listaasistenciadiaria").html(data);                
            },
            error: function (data) {

                cerrarcargando();
                
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaasistenciadiaria").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });




    /******* reporte diario ******/


    $('#buscarreporteasistenciadiariafull').on('click', function(event){

        var _token              = $('#token').val();
        var idempresa           = $('#empresa_id').val();
        var fecha               = $('#fecha').val();        
        var sede_id             = $('#sede_id').val(); 


        if(idempresa.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }

        if(fecha == ''){
            alerterrorajax("Seleccione una fecha para el reporte");
            return false;
        }

        abrircargando();

        var textoajax   = $('.listaasistenciadiaria').html(); 
        $(".listaasistenciadiaria").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-asistencia-diaria-full",
            data    :   {
                            _token      : _token,
                            idempresa   : idempresa,
                            sede_id     : sede_id,                            
                            fecha       : fecha
                        },
            success: function (data) {
                cerrarcargando();
                $(".listaasistenciadiaria").html(data);                
            },
            error: function (data) {

                cerrarcargando();
                
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaasistenciadiaria").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });



    $('#descargarasistenciaindividuallexcel').on('click', function(event){

        var _token              = $('#token').val();
        var trabajador_id       = $('#trabajador_id').select2().val();
        var sede_id             = $('#sede_id').select2().val();        
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 


        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }     

        href = $(this).attr('data-href')+'/'+sede_id+'/'+trabajador_id+'/'+fechainicio+'/'+fechafin;
        $(this).prop('href', href);
        return true;


    });



    $('#descargarasistenciafullexcel').on('click', function(event){

        var _token              = $('#token').val();
        var idempresa           = $('#empresa_id').val();
        var fecha               = $('#fecha').val(); 
        var sede_id             = $('#sede_id').val();                

        if(idempresa.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }

        if(fecha == ''){
            alerterrorajax("Seleccione una fecha para el reporte");
            return false;
        }

        href = $(this).attr('data-href')+'/'+sede_id+'/'+idempresa+'/'+fecha;
        $(this).prop('href', href);
        return true;


    });
    

    $('#descargarasistenciamintrapdf').on('click', function(event){

        var _token              = $('#token').val();
        var empresa_id          = $('#empresa_id').select2().val();
        var area_id             = $('#area_id').select2().val();                
        var trabajador_id       = $('#trabajador_id').select2().val();
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 
        var sede_id             = $('#sede_id').select2().val(); 
        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }

        if(empresa_id.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }
        if(area_id.length<=0){
            alerterrorajax("Seleccione un area para el reporte");
            return false;
        }
        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }    
        
        href = $(this).attr('data-href')+'/'+sede_id+'/'+empresa_id+'/'+area_id+'/'+trabajador_id+'/'+fechainicio+'/'+fechafin;
        $(this).prop('href', href);
        return true;


    });



    $('#descargarasistenciamintraexcel').on('click', function(event){

        var _token              = $('#token').val();
        var empresa_id          = $('#empresa_id').select2().val();
        var area_id             = $('#area_id').select2().val();                
        var trabajador_id       = $('#trabajador_id').select2().val();
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 
        var sede_id             = $('#sede_id').select2().val(); 
        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }

        if(empresa_id.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }
        if(area_id.length<=0){
            alerterrorajax("Seleccione un area para el reporte");
            return false;
        }
        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }    
        
        href = $(this).attr('data-href')+'/'+sede_id+'/'+empresa_id+'/'+area_id+'/'+trabajador_id+'/'+fechainicio+'/'+fechafin;
        $(this).prop('href', href);
        return true;


    });




    $('#descargarasistenciaexcel').on('click', function(event){

        var _token              = $('#token').val();
        var idempresa           = $('#empresa_id').val();
        var sede_id             = $('#sede_id').val();           
        var fecha               = $('#fecha').val();        



        if(idempresa.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }

        if(fecha == ''){
            alerterrorajax("Seleccione una fecha para el reporte");
            return false;
        }

        href = $(this).attr('data-href')+'/'+sede_id+'/'+idempresa+'/'+fecha;
        $(this).prop('href', href);
        return true;


    });


    $('#buscarreporteasistenciadiariamintra').on('click', function(event){

        var _token              = $('#token').val();
        var empresa_id          = $('#empresa_id').select2().val();
        var sede_id             = $('#sede_id').select2().val();        
        var area_id             = $('#area_id').select2().val();                
        var trabajador_id       = $('#trabajador_id').select2().val();
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 

        if(sede_id.length<=0){
            alerterrorajax("Seleccione una sede para el reporte");
            return false;
        }

        if(empresa_id.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }
        if(area_id.length<=0){
            alerterrorajax("Seleccione un area para el reporte");
            return false;
        }
        if(trabajador_id.length<=0){
            alerterrorajax("Seleccione un trabajador para el reporte");
            return false;
        }

        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin para el reporte");
            return false;
        }    

        abrircargando();

        var textoajax   = $('.listaasistenciadiaria').html(); 
        $(".listaasistenciadiaria").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-asistencia-diaria-mintra",
            data    :   {
                            _token          : _token,
                            sede_id         : sede_id,
                            empresa_id      : empresa_id,                            
                            area_id         : area_id,                                                        
                            trabajador_id   : trabajador_id,
                            fechainicio     : fechainicio,
                            fechafin        : fechafin
                        },
            success: function (data) {

                cerrarcargando();
                $(".listaasistenciadiaria").html(data);
                
            },
            error: function (data) {

                cerrarcargando();
                


                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaasistenciadiaria").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }


            }
        });


    });




    $('#buscarreporteasistenciadiaria').on('click', function(event){

        var _token              = $('#token').val();
        var idempresa           = $('#empresa_id').val();
        var sede_id             = $('#sede_id').val();        
        var fecha               = $('#fecha').val();        



        if(idempresa.length<=0){
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }

        if(fecha == ''){
            alerterrorajax("Seleccione una fecha para el reporte");
            return false;
        }

        abrircargando();

        var textoajax   = $('.listaasistenciadiaria').html(); 
        $(".listaasistenciadiaria").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-asistencia-diaria",
            data    :   {
                            _token      : _token,
                            idempresa   : idempresa,
                            sede_id     : sede_id,                            
                            fecha       : fecha
                        },
            success: function (data) {

                cerrarcargando();
                $(".listaasistenciadiaria").html(data);
                
            },
            error: function (data) {

                cerrarcargando();
                


                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaasistenciadiaria").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }


            }
        });


    });





    $('#descargarhorario').on('click', function(event){

        var _token              = $('#token').val();
        var idempresa           = $('#empresa_id').val();


        if(idempresa.length>0){

            idempresa = idempresa;
            href = $(this).attr('data-href')+'/'+idempresa;
            $(this).prop('href', href);
            return true;

        }else{
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }

    });


    $('#buscarreportehorario').on('click', function(event){

        var _token              = $('#token').val();
        var idempresa           = $('#empresa_id').val();


        if(idempresa.length>0){

            abrircargando();
                
            $(".listahorarios").html("");

            $.ajax({
                type    :   "POST",
                url     :   carpeta+"/ajax-lista-horarios",
                data    :   {
                                _token   : _token,
                                idempresa : idempresa
                            },
                success: function (data) {

                    cerrarcargando();
                    $(".listahorarios").html(data);
                    
                },
                error: function (data) {
                    cerrarcargando();
                    console.log('Error:', data);
                }
            });

        }else{
            alerterrorajax("Seleccione una empresa para el reporte");
            return false;
        }

    });




});