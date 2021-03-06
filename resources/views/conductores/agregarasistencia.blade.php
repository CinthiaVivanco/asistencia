@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
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

            <form method="POST" action="{{ url('/agregar-asistencia/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}

              <div class="form-group">
                <label class="col-sm-3 control-label">Conductores</label>
                <div class="col-sm-6">

                      {!! Form::select( 'pilotos', $combopilotos, array(),
                                        [
                                          'class'       => 'form-control control select2' ,
                                          'id'          => 'pilotos',
                                          'required'    => '',
                                          'data-aw'     => '1',
                                        ]) !!}

                </div>
              </div>


              <div class="form-group">
                  <label class="col-sm-3 control-label">Fecha Asistencia
                  </label> 
                  <div class="col-sm-6"> 
                    <div data-min-view="2" data-date-format="dd-mm-yyyy"  class="input-group date datetimepicker">
                              <input size="16" type="text" value="{{$ffin}}" placeholder="Fecha Asistencia"
                              id='fechaasistencia' name='fechaasistencia' 
                              required = ""
                              class="form-control input-sm">
                              <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                    </div>
                  </div>
              </div>




              <div class="form-group">
                    <label class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-6">

                      <input  type="text"
                              id="motivo" name='motivo' value="" placeholder="Motivo"
                              required = ""
                              autocomplete="off" class="form-control input-sm" data-aw="4"/>

                    </div>
              </div>

              <div class="row xs-pt-15">
                <div class="col-xs-6">
                    <div class="be-checkbox">

                    </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                  </p>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>


  </div>
</div>  



@stop

@section('script')



    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/i18n/es.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>


    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        $('#pilotos').select2();
        App.init();
        App.formElements();
        $('form').parsley();


      });
    </script> 

    <script src="{{ asset('public/js/conductor/conductor.js?v='.$version) }}" type="text/javascript"></script>
@stop