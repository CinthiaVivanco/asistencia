@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')



  <div class="be-content">
    <div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">


                <div class="panel-heading">Asistencia Periodos
                  <div class="tools tooltiptop">

                    <a href="#" class="tooltipcss" id='buscardiasxperiodo' >
                      <span class="tooltiptext">Buscar Periodo</span>
                      <span class="icon mdi mdi-search"></span>
                    </a>

                  </div>
                </div>
                <div class="panel-body">

                  <div class='filtrotabla row'>
                    <div class="col-xs-12">

                      <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">

                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft" >Periodo :</label>
                            <div class="col-sm-12 abajocaja" >
                              {!! Form::select( 'sede_id', $comboperiodos, array(),
                                                [
                                                  'class'       => 'form-control control input-sm' ,
                                                  'id'          => 'periodo_id',
                                                  'required'    => '',
                                                  'data-aw'     => '1',
                                                ]) !!}
                            </div>
                          </div>
                      </div>

                  </div>
                  <div class="col-xs-12">
                    <div class='listadiasxperiodo listajax reporteajax'>
                        <div class='ajaxvacio'>
                          Seleccione un periodo ...

                        </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
    </div>
  </div>

@stop

@section('script')


  <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/js/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>







    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script> 

    <script src="{{ asset('public/js/mantenimiento/periodo.js?v='.$version) }}" type="text/javascript"></script> 
@stop