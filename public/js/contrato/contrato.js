$(document).ready(function(){

    var carpeta = $("#carpeta").val();


    window.Parsley.addValidator('fechamayor', {
      validateString: function(value, requirement) {
        var $fechamenor = $('#'+requirement).val();
        return validate_fechaMayorQue($fechamenor,value);
      },
      messages: {
        es: 'La fecha debe ser mayor a la %s.'
      }
    });

    $(".ajaxpersonal").on('click','#guardarcontrato', function() {

          var $form = $('form');
          $form.parsley().validate()


          $(".tab-content .tab-pane").each(function(index){

              var error = $(this).find('.filled').html();
              var menu  = $(this).attr('id');

              if (error === undefined || error === null || error === '') {
                  $(".tab"+menu+' .errortabc').css("display", "none");
                  $(".tab"+menu+' .bientabc').css("display", "block");
              }else{
                  $(".tab"+menu+' .errortabc').css("display", "block");
                  $(".tab"+menu+' .bientabc').css("display", "none");
              }

          });


    });
    /*****************************************************************************/

 

       //SOLO NUMEROS
    $(function(){
        $(".validarnumero").keydown(function(event){
            //alert(event.keyCode);
            if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !==190  && event.keyCode !==110 && event.keyCode !==8 && event.keyCode !==9  ){
                return false;

            }
        });
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



    $(".editc").on('click','#btnmodificarc', function() {

        
        var id              = $(this).attr('name');
        var idopcion        = $(this).attr('data_opcion');
        var idtrabajador    = $(this).attr('data_trabajador');
        
        var _token          = $('#token').val();


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-form-contrato",
            data    :   {
                            _token          : _token,
                            id              : id,
                            idopcion        : idopcion,
                            idtrabajador    : idtrabajador                                                       
                        },
            success: function (data) {

                $(".ajaxformc").html(data);

            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });


    $(".detver").on('click','.icono', function() {

        var idcontrato      = $(this).find('span').attr('name');
        var _token          = $('#token').val();
        $(".ajax-modal").html(""); // se limpia ese contenedor

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-contrato",
            data    :   {
                            _token          : _token,
                            idcontrato      : idcontrato,
                                                    
                        },
            success: function (data) {

                $(".ajax-modal").html(data);  // ajax nos pide el sector que se va actualizar en este caso vamos aca

            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });

    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

    $('#fechainicio').datepicker({
        minDate: today,
        maxDate: function () {
            return $('#fechafin').val();
        }
    });
    $('#fechafin').datepicker({
        minDate: function () {
            return $('#fechainicio').val();
        }
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
