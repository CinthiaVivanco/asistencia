$(document).ready(function(){

    var carpeta = $("#carpeta").val();


    gradoacademico('1');


    //SOLO NUMEROS
    $(function(){
        $(".validarnumero").keydown(function(event){
            //alert(event.keyCode);
            if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !==190  && event.keyCode !==110 && event.keyCode !==8 && event.keyCode !==9  ){
                return false;

            }
        });
    });

    //INPUT MAYÚSCULAS

    $('.validarmayusculas').keyup(function(){
        this.value = this.value.toUpperCase();
    });


    //SOLO LETRAS
    $(function(){
        $(".validarletras").keydown(function(event){
            //alert(event.keyCode);

            if((event.keyCode  >= 65  && event.keyCode <= 90) ||  (event.keyCode >= 97 && event.keyCode <= 122) ||  (event.keyCode == 32 || event.keyCode == 8 )){
                return true;
            }else {
                return false;
            }
        });
    });

    $(".panelhorarioempresa").on('change','#empresa_id', function() { 
        
        var _token              = $('#token').val();
        var empresa             = $('#empresa_id').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-area-horario-cargo-empresa-id",
            data    :   {
                            _token   : _token,
                            empresa  : empresa
                        },
            success: function (data) {

                $(".ajaxareahorariocargo").html(data);
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

    $(".panelhorarioempresa").on('change','#empresa_id', function() {

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

    $(".panelhorarioempresa").on('change','#empresa_id', function() {
        var empresa_id = $('#empresa_id').val();
        var _token      = $('#token').val();

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-select-local-empresa",
            data    :   {
                            _token  : _token,
                            empresa_id : empresa_id
                        },
            success: function (data) {

                $(".ajaxlocalempresa").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });

    //  $("#menu2").on('change','.tipotrabajador', function() {


    //     $valortipo = $(this).val();

    //     if(($valortipo == 'PRMAECEN000000000005') || ($valortipo == 'PRMAECEN000000000022') || ($valortipo == 'PRMAECEN000000000024')){
    //         $('.niveleducativo').addClass( "hide" );
    //         $(".niveleducativo").attr("required",false);

    //     }else{
            
    //         $('.niveleducativo').removeClass( "hide" );
    //         $(".niveleducativo").attr("required",true);
    //     }
    // });

    $("#menu1").on('change','.dnipais', function() {

        var valor = $(this).val();
        if(valor == 'PRMAECEN000000000004'){
            $('.paisemisordocumento').show();

        }else{

            $('.paisemisordocumento').hide();
        }
        
    });

    $("#menu1").on('change','.dnivalidar', function() {

        var valor2 = $(this).val();
        if((valor2 == 'PRMAECEN000000000001') || (valor2 == 'PRMAECEN000000000005')){
            $('.nacionalidadt').hide();

        }else{

            $('.nacionalidadt').show();
        }
        
    });

/***************************** DNI VALIDAR DEL DERECHOHABIENTE *****************************/
    $("#menu1").on('change','.dnivalidar', function() {

        var valor1 = $(this).val();

        if(valor1 == 'PRMAECEN000000000001'){
            $("#dnihabiente").attr("maxlength",8);
            $("#dnihabiente").attr('minlength',8);
        } 
        
        if(valor1 == 'PRMAECEN000000000002'){
            $("#dnihabiente").attr("maxlength",11);
            $("#dnihabiente").attr('minlength',11);
        }
       
        if(valor1 == 'PRMAECEN000000000004'){
            $("#dnihabiente").attr("maxlength",15);
            $("#dnihabiente").attr('minlength',15);
        }

        if(valor1 == 'PRMAECEN000000000005'){
            $("#dnihabiente").attr("maxlength",6);
            $("#dnihabiente").attr('minlength',6);
        }
    });

/***************************** DNI VALIDAR DEL TRABAJADOR  *****************************/
    $("#menu1").on('change','.dnivalidar', function() {

        var valor1 = $(this).val();

        if(valor1 == 'PRMAECEN000000000001'){
            $("#dni").attr("maxlength",8);
            $("#dni").attr('minlength',8);
        } 
        
        if(valor1 == 'PRMAECEN000000000002'){
            $("#dni").attr("maxlength",11);
            $("#dni").attr('minlength',11);
        }
       
        if(valor1 == 'PRMAECEN000000000004'){
            $("#dni").attr("maxlength",15);
            $("#dni").attr('minlength',15);
        }

        if(valor1 == 'PRMAECEN000000000005'){
            $("#dni").attr("maxlength",6);
            $("#dni").attr('minlength',6);
        }
    });



    $("#menu1").on('change','.codigotelefono', function() {

        var valor3 = $(this).val();
        if(valor3 == 'PRMAECEN000000000001'){
            $(".telefonocorto").attr("maxlength",7);
            $(".telefonocorto").attr('minlength',7);

        }else{

            $(".telefonocorto").attr("maxlength",6);
            $(".telefonocorto").attr('minlength',6);
        }

        
    });

    /*****/


    $('.nivel').on('change','#situacioneducativa_id', function() {

        gradoacademico('0');

    })

 
    $(".ltipovivienda").on('click','.tipodevivienda', function() {


        $valor = $(this).attr('data-value');
        $('#otrotipovivienda').val("");

        if($valor == 'Otros'){
            $('#otrotipovivienda').removeClass( "hide" );
            $('#otrotipovivienda').attr("required", true);



        }else{
            $('#otrotipovivienda').addClass( "hide" );
            $('#otrotipovivienda').attr("required", false);
        }

        
    });


    $('#buscartrabajadorbaja').on('click', function(event){

        var dni     = $("#dni").val();
        var _token  = $('#token').val();
        abrircargando();
        $(".trabajadorencontradobaja").html("");


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-baja-del-trabajador",
            data    :   {
                            _token  : _token,
                            dni     : dni
                        },
            success: function (data) {
                //console.log(data);
                cerrarcargando();
                $(".trabajadorencontradobaja").html(data);
            },
            error: function (data) {
                cerrarcargando();
                console.log('Error:', data);
            }
        });

    }); 


    $(".otrarenta").on('click','.radio', function() {

        $valor =$("input[name='rentaquinta']:checked").val(); 
        $('#otrarentaquinta').val("");

        if($valor == '1'){
           $('#otrarentaquinta').removeClass( "hide" );
           $('#otrarentaquinta').attr("required", true);


        }else{

           $('#otrarentaquinta').addClass( "hide" );
           $('#otrarentaquinta').attr("required", false);
        }

    });


    $(".lmaterial").on('click','.tipomaterial', function() {


        $valor = $(this).attr('data-value');
        $('#otromaterial').val("");

        if($valor == 'Otros'){
            $('#otromaterial').removeClass( "hide" );
            $('#otromaterial').attr("required", true);
        }else{
            $('#otromaterial').addClass( "hide" );
            $('#otromaterial').attr("required", false);
        }

        
    });

    $(".lenfermedad").on('click','.tipoenfermedad', function() {


        $valor = $(this).attr('data-value');
        $('#otraenfermedad').val("");

        if($valor == 'Otras'){
            $('#otraenfermedad').removeClass( "hide" );
            $('#otraenfermedad').attr("required", true);
        }else{
            $('#otraenfermedad').addClass( "hide" );
            $('#otraenfermedad').attr("required", false);
        }

        
    });
     

/*

{"position":'absolute !important', "margin-top":'-97px !important', "margin-left":'156px !important'};
    $(".guardarfichasocioeconomica").on("click",function(){
        $("#radio2").css({
           'position':'relative','margin-top':'0px','margin-left':'0px'
        })
    });

    $(".guardarfichasocioeconomica").on('click','.guardarfichasocioeconomica', function() {

         if($("#tipovivienda").val() == ""){
        alert("Seleccione un tipo de vivienda");
        return false;
         }
        
    });
*/
    

    /* FIN DE LA FICHA TRABAJADOR*/

    $(".detmodificar").on('click','#btnmodificar', function() {

        
        var id              = $(this).attr('name');
        var idopcion        = $(this).attr('data_opcion');
        var idtrabajador    = $(this).attr('data_trabajador');
        

        var _token          = $('#token').val();


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-form-derechohabiente",
            data    :   {
                            _token          : _token,
                            id              : id,
                            idopcion        : idopcion,
                            idtrabajador    : idtrabajador                                                       
                        },
            success: function (data) {

                $(".ajaxformdh").html(data);

            },
            error: function (data) {

                console.log('Error:', data);
            }


        });

    });


    $(".editfs").on('click','#btnmodificarfs', function() {

        
        var id              = $(this).attr('name');
        var idopcion        = $(this).attr('data_opcion');
        var idtrabajador    = $(this).attr('data_trabajador');
        
        var _token          = $('#token').val();



        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-form-fichasocioeconomica",
            data    :   {
                            _token          : _token,
                            id              : id,
                            idopcion        : idopcion,
                            idtrabajador    : idtrabajador                                                       
                        },
            success: function (data) {

                $(".ajaxformfs").html(data);

            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });




/*
    $(".editc").on('click','#btnverc', function() {

        
        var id              = $(this).attr('name');
        var idopcion        = $(this).attr('data_opcion');
        var idcontrato      = $(this).attr('data_contrato');
        
        var _token          = $('#token').val();



        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-form-contrato",
            data    :   {
                            _token          : _token,
                            id              : id,
                            idopcion        : idopcion,
                            idcontrato      : idcontrato                                                       
                        },
            success: function (data) {

                $(".ajaxformc").html(data);

            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });
    */

	$(".ajaxpersonal").on('change','#departamentos_id', function() {
		var departamentos_id = $('#departamentos_id').val();
    	var _token 		= $('#token').val();

        $.ajax({
            
            type	: 	"POST",
            url		: 	carpeta+"/ajax-select-provincia",
            data	: 	{
            				_token	: _token,
            				departamentos_id : departamentos_id
            	 		},
            success: function (data) {

            	$(".ajaxprovincia").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });


	$(".ajaxpersonal").on('change','#provincia_id', function() {

		var provincia_id = $('#provincia_id').val();

    	var _token 		= $('#token').val();

        $.ajax({

            type	: 	"POST",
            url		: 	carpeta+"/ajax-select-distrito",
            data	: 	{
            				_token	: _token,
            				provincia_id : provincia_id
            	 		},
            success: function (data) {

            	$(".ajaxdistrito").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });

    // $(".ajaxpersonal").on('change','#empresa_id', function() {
    //     var empresa_id = $('#empresa_id').val();
    //     var _token      = $('#token').val();

    //     $.ajax({
            
    //         type    :   "POST",
    //         url     :   carpeta+"/ajax-select-local",
    //         data    :   {
    //                         _token  : _token,
    //                         empresa_id : empresa_id
    //                     },
    //         success: function (data) {

    //             $(".ajaxlocal").html(data);
    //         },
    //         error: function (data) {

    //             console.log('Error:', data);
    //         }
    //     });
    // });


    // $(".ajaxpersonal").on('change','#gerencia_id', function() {
    //     var gerencia_id = $('#gerencia_id').val();
    //     var _token      = $('#token').val();

    //     $.ajax({
            
    //         type    :   "POST",
    //         url     :   carpeta+"/ajax-select-area",
    //         data    :   {
    //                         _token  : _token,
    //                         gerencia_id : gerencia_id
    //                     },
    //         success: function (data) {

    //             $(".ajaxarea").html(data);
    //         },
    //         error: function (data) {

    //             console.log('Error:', data);
    //         }
    //     });


    // });
     

    // $(".ajaxpersonal").on('change','#area_id', function() {

    //     var area_id = $('#area_id').val();

    //     var _token      = $('#token').val();

    //     $.ajax({

    //         type    :   "POST",
    //         url     :   carpeta+"/ajax-select-unidad",
    //         data    :   {
    //                         _token  : _token,
    //                         area_id : area_id
    //                     },
    //         success: function (data) {

    //             $(".ajaxunidad").html(data);
    //         },
    //         error: function (data) {

    //             console.log('Error:', data);
    //         }
    //     });

    // });

    // $(".ajaxpersonal").on('change','#unidad_id', function() {

    //     var unidad_id = $('#unidad_id').val();

    //     var _token      = $('#token').val();

    //     $.ajax({

    //         type    :   "POST",
    //         url     :   carpeta+"/ajax-select-cargo",
    //         data    :   {
    //                         _token  : _token,
    //                         unidad_id : unidad_id
    //                     },
    //         success: function (data) {

    //             $(".ajaxcargo").html(data);
    //         },
    //         error: function (data) {

    //             console.log('Error:', data);
    //         }
    //     });

    // });


    $(".ajaxpersonal").on('change','#vinculofamiliar_id', function() {
        var vinculofamiliar_id = $('#vinculofamiliar_id').val();
        var _token      = $('#token').val();
        //este es un punto de quiebre debugger
        //debugger;

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-select-tipodocumentoacredita",
            data    :   {
                            _token  : _token,
                            vinculofamiliar_id : vinculofamiliar_id
                        },
            success: function (data) {

                $(".ajaxtipodocumentoacredita").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });


    $(".ajaxpersonal").on('change','#regimeninstitucion_id', function() {

        var regimeninstitucion_id = $('#regimeninstitucion_id').val();
        var _token      = $('#token').val();
        if($('#swga').val()=='1'){return false;}

        $.ajax({

            type    :   "POST",
            url     :   carpeta+"/ajax-select-tipoinstitucion",
            data    :   {
                            _token  : _token,
                            regimeninstitucion_id : regimeninstitucion_id
                        },
            success: function (data) {

                $(".ajaxtipoinstitucion").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });


    $(".ajaxpersonal").on('change','#tipoinstitucion_id', function() {

        var tipoinstitucion_id = $('#tipoinstitucion_id').val();
        var _token      = $('#token').val();
        if($('#swga').val()=='1'){return false;}


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-institucion",
            data    :   {
                            _token  : _token,
                            tipoinstitucion_id : tipoinstitucion_id
                        },
            success: function (data) {

                $(".ajaxinstitucion").html(data);

            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });


    $(".ajaxpersonal").on('change','#institucion_id', function() {

        var institucion_id = $('#institucion_id').val();
        var _token      = $('#token').val();
        if($('#swga').val()=='1'){return false;}


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-carrera",
            data    :   {
                            _token  : _token,
                            institucion_id : institucion_id
                        },
            success: function (data) {

                $(".ajaxcarrera").html(data);

            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });


    $(function(){

        $(".panel-body").on('click','.btn-circle', function() {
 
        //$('.btn-circle').on('click',function(){ // c
           
            $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

            $(this).addClass('btn-info').removeClass('btn-default').blur();
        });

        $(".panel-body").on('click','.next-step, .prev-step', function(e) {
        //$('.next-step, .prev-step').on('click', function (e){

           var $activeTab = $('.tab-pane.active');
            
           $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

           if ( $(e.target).hasClass('next-step') )
           {
              var nextTab = $activeTab.next('.tab-pane').attr('id');
              $('[href="#'+ nextTab +'"]').addClass('btn-info').removeClass('btn-default');
              $('[href="#'+ nextTab +'"]').tab('show');
           }
           else
           {
              var prevTab = $activeTab.prev('.tab-pane').attr('id');
              $('[href="#'+ prevTab +'"]').addClass('btn-info').removeClass('btn-default');
              $('[href="#'+ prevTab +'"]').tab('show');
           }

        });
    });



});

function gradoacademico(valor){

        $variable = $("#situacioneducativa_id option:selected").text(); 


        // ya aca limpiamos antes de ingresar ok
        $('#swga').val('1');


        if(($variable == 'TITULADO') || ($variable == 'GRADO DE BACHILLER') || ($variable == 'UNIVERSITARIA COMPLETA') || ($variable == 'SUPERIOR COMPLETA(INSTIT SUPER)') || ($variable == 'ESTUD. MAESTRÍA COMPLETA') || ($variable == 'GRADO DE MAESTRÍA') || ($variable == 'ESTUD. DOCTORADO INCOMPLETO')
            || ($variable == 'ESTUD. DOCTORADO COMPLETO') || ($variable == 'GRADO DE DOCTOR')) {



                $("#contentestudiosid").css("display", "block");

                $('.radioestudios').attr("required", true);
                $('#regimeninstitucion_id').attr("required", true);
                $('.ajaxtipoinstitucion #tipoinstitucion_id').attr("required", true);
                $('.ajaxinstitucion #institucion_id').attr("required", true);
                $('.ajaxcarrera #carrera_id').attr("required", true);
                $('#anioegreso').attr("required", true);

             
        }else{

                $("#contentestudiosid").css("display", "none");

                $('.radioestudios').attr("required", false);
                $('#regimeninstitucion_id').attr("required", false);
                $('.ajaxtipoinstitucion #tipoinstitucion_id').attr("required", false);
                $('.ajaxinstitucion #institucion_id').attr("required", false);
                $('.ajaxcarrera #carrera_id').attr("required", false);
                $('#anioegreso').attr("required", false);

        }

        if(valor==1){$('#swga').val('0'); return false ;}
        $('.radioestudios').removeAttr('checked');
        $("#regimeninstitucion_id").val("").change(); 
        $("#tipoinstitucion_id").val("").change();
        $("#institucion_id").val("").change();
        $("#carrera_id").val("").change();
        $('#anioegreso').val('');
        $('#swga').val('0');


}