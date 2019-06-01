@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/selectlist/fastselect.min.css') }} "/>

@stop
@section('section')


<div class="be-content">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider" >Agregar Asistencia<span class="panel-subtitle">Agregar asistencia de un conductor</span></div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/agregar-usuario/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}

              <div class="form-group">
                  <label class="col-sm-3 control-label">Conductores</label>
                  <div class="col-sm-5 input-group xs-mb-15">

                    <input type="text" 
                          class="selectconductor input-sm" 
                          data-url="{{url('/lista-de-conductores-json.json')}}"
                          data-load-once="true" 
                          name="language" />
                    
                  </div>
              </div>

         <!--      <div class="listajax panel-body listadotrabajadores">

              </div> -->


            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>  



@stop

@section('script')


    <script src="{{ asset('public/js/general/jquery.scrollbar.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/selectlist/fastselect.standalone.js') }}" type="text/javascript"></script>




    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip();


      });
    </script> 

    <script src="{{ asset('public/js/conductor/conductor.js?v='.$version) }}" type="text/javascript"></script>
@stop