$(document).ready(function(){
    var carpeta = $("#carpeta").val();


    $('.selectconductor').fastselect({
        onItemSelect: function($item, itemModel) {

            var _token              = $('#token').val();
            var idtrabajador         = itemModel.value;
            $(".listadoconductores").html("");

            $.ajax({
                type    :   "POST",
                url     :   carpeta+"/ajax-listado-de-rubros-x-trabajador",
                data    :   {
                                _token   : _token,
                                idtrabajador  :  idtrabajador
                            },
                success: function (data) {
                    $(".listadotrabajadores").html(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });


});

