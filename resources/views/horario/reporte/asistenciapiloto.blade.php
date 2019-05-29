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


                <div class="panel-heading">Asistencia Piloto
                  <div class="tools tooltiptop">


                    <a href="{{url('/asistencia-conductores-excel')}}" 
                       class='tooltipcss'
                       target="_blank"
                       id="descargarasistenciapilotolexcel" 
                       data-href="{{url('/asistencia-conductores-excel')}}"
                       title="Descargar asistencia mensual">
                       <span class="tooltiptext">Descargar Asistencia Piloto</span>
                       <i class="fa fa-file-excel-o"></i>
                    </a>


                  </div>
                </div>
                <div class="panel-body selectfiltro">

                  <div class='filtrotabla row'>

                    <div class="col-xs-12">

                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 cajareporte">

                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft" >Periodo :</label>
                            <div class="col-sm-12 abajocaja" >
                              {!! Form::select( 'periodo_id', $comboperiodopiloto, array(),
                                                [
                                                  'class'       => 'select2 form-control control input-sm' ,
                                                  'id'          => 'periodo_id',
                                                  'required'    => '',
                                                  'data-aw'     => '1',
                                                ]) !!}
                            </div>
                          </div>
                      </div>
                     
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 cajareporte">

                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft" >Sede :</label>
                            <div class="col-sm-12 abajocaja" >
                              {!! Form::select( 'sede_id', $combosede, array(),
                                                [
                                                  'class'       => 'select2 form-control control input-sm' ,
                                                  'id'          => 'sede_id',
                                                  'required'    => '',
                                                  'data-aw'     => '2',
                                                ]) !!}
                            </div>
                          </div>
                      </div>

                  </div>
                  <div class="col-xs-12">
                    <div class='listaasistenciadiaria listajax reporteajax'>
                        <div class='ajaxvacio'>
                          Seleccione una periodo y sede correspondientes ...

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


  <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>


    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script> 

    <script src="{{ asset('public/js/horario/reporte/horario.js?v='.$version) }}" type="text/javascript"></script> 
@stop