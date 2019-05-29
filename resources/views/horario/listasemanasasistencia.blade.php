@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/scrollbar/scrollbar.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-select/css/bootstrap-select.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/timepicki/css/timepicki.css') }} "/>
   
@stop
@section('section')

<div class="be-content panelhorario">
  <div class="main-content container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <!--Dropdowns-->
        <div class="panel panel-default">
          <div class="panel-heading panel-heading-divider">Semanas<span class="panel-subtitle">Lista de semanas para asignar horario (seleccione una semana)</span></div>
          <div class="panel-body">
            <div class="row content ">
              <div class="col-md-4">
                <div class="panel panel-contrast">
                  <div class="panel-heading panel-heading-contrast">Semanas<span class="panel-subtitle">seleccione una semana</span></div>
                  <div class="panel-body">
                    <div class="demo col-xs-11">


                      <div class="form-group ">

                        <label class="col-sm-12 control-label labelleft" style='padding-left:0px;' >Sedes :</label>
                        <div class="col-sm-12" style='padding-left:0px;'>
                          {!! Form::select( 'sede_id', $combosede, array(),
                                            [
                                              'class'       => 'form-control control input-sm' ,
                                              'id'          => 'sede_asistencia_id',
                                              'required'    => '',
                                              'data-aw'     => '1',
                                            ]) !!}
                        </div>
                      </div>


                      <div class="dropdown scrollbar-inner">
                        <ul style="display: block; position: relative;" class="dropdown-menu menu-roles listasemana">
                          @foreach($listasemana as $item)
                             <li >
                                <a href="#"  id="{{Hashids::encode(substr($item->id, -12))}}" 
                                class="selectsemanaasistencia">
                                  <span class="icon mdi mdi-time @if ($hoy >= $item->fechainicio &&  $hoy <= $item->fechafin) clockactivo @endif" data='{{$item->numero}}'></span>

                                  ({{date_format(date_create($item->fechainicio), 'd/m/Y')}}) - 
                                  ({{date_format(date_create($item->fechafin), 'd/m/Y')}})
                                </a>
                             </li>  
                          @endforeach  
                        </ul> 
                      </div>

                      <input type='hidden' id='lista_semana_id' value = '' >

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="panel panel-contrast">
                  <div class="panel-heading panel-heading-contrast">Filtros<span class="panel-subtitle">Filtros para horario</span></div>
                  <div class="panel-body">


                    <div class="form-group ">

                      <label class="col-sm-12 control-label labelleft" >Empresa :</label>
                      <div class="col-sm-12 abajocaja" >
                        {!! Form::select( 'empresa_id', $comboempresa, array(),
                                          [
                                            'class'       => 'form-control control input-sm' ,
                                            'id'          => 'empresa_id',
                                            'required'    => '',
                                            'data-aw'     => '1',
                                          ]) !!}
                      </div>
                    </div>

                    <div class='ajaxarea'>
                      <div class="form-group ">

                        <label class="col-sm-12 control-label labelleft" >Area :</label>
                        <div class="col-sm-12 abajocaja" >
                          {!! Form::select( 'area_id', $comboarea, array(),
                                            [
                                              'class'       => 'form-control control input-sm' ,
                                              'id'          => 'area_id',
                                              'required'    => '',
                                              'data-aw'     => '2',
                                            ]) !!}
                        </div>
                      </div>                
                    </div>

                  </div>
                </div>
              </div>





            </div>

            <div class="content row dropdown-showcase">
              <!--Basic Dropdown-->

              <div class="panel panel-default col-xs-12">
                <div class="listajax panel-body listadohorario">


                    

                </div>
              </div>

            </div>



          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div id="mod-horaasistencia" tabindex="-1" role="dialog" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
      </div>
      <div class="modal-body">
        <div class="text-center ajaxhoraasistencia">

            <div class='ajaxvacio'>
              Cargando ......
            </div>

        </div>
      </div>
      <div class="modal-footer"></div>
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
    <script src="{{ asset('public/lib/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/timepicki/js/timepicki.js') }}" type="text/javascript"></script>



    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip();

        });
    </script>

    <script src="{{ asset('public/js/horario/horario.js?v='.$version) }}" type="text/javascript"></script> 
@stop