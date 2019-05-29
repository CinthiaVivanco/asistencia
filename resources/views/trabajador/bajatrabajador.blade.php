@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/alfasweb.css')}}"/>

@stop
@section('section')

<div class="be-content">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">TRABAJADOR<span class="panel-subtitle">Baja de un trabajador</span></div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/baja-trabajador/'.$idopcion.'/'.Hashids::encode(substr($trabajador->id, -12))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed"> 
                  {{ csrf_field() }}

                        <div class="col-sm-6 col-md-offset-3">
                          <div class="panel-body">
                             <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft">Trabajador</label>
                                    <div class="col-sm-5 abajocaja nivel" >
                                      <input  type="text"
                                        id="nombre" name='nombre' value="@if(isset($trabajador)){{old('nombre',$trabajador->nombres)}} {{old('nombre',$trabajador->apellidopaterno)}} {{old('nombre',$trabajador->apellidomaterno)}}@else{{old('nombre')}}@endif" placeholder="Nombre del Trabajador"
                                        required = "" disabled="disabled"
                                        autocomplete="off" class="form-control input-sm" data-aw="1"/>
                                      </div>
                             </div>

                                       <input  type="hidden" id="trabajador_id" name='trabajador_id'/>

                                       <input  type="hidden"
                                                id="apellidopaterno" name='apellidopaterno' value="@if(isset($trabajador)){{old('apellidopaterno',$trabajador->apellidopaterno)}}@else{{old('apellidopaterno')}}@endif" placeholder="Apellido Paterno"
                                                required = "" maxlength="40"
                                                autocomplete="off" class="form-control input-sm validarletras" data-aw="3"/>


                                       <input  type="hidden"
                                                id="apellidomaterno" name='apellidomaterno' value="@if(isset($trabajador)){{old('apellidomaterno',$trabajador->apellidomaterno)}}@else{{old('apellidomaterno')}}@endif" placeholder="Apellido Materno"
                                                required = "" maxlength="40" 
                                                autocomplete="off" class="form-control input-sm validarletras" data-aw="4"/>


                                       <input  type="hidden"
                                                id="nombre" name='nombre' value="@if(isset($trabajador)){{old('nombre',$trabajador->nombres)}}@else{{old('nombre')}}@endif" placeholder="Nombres" required = "" maxlength="40"
                                                autocomplete="off" class="form-control input-sm validarletras" data-aw="5"/>


                              <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft">Estado</label>
                                    <div class="col-sm-5">
                                      <div class="be-radio has-success inline">
                                        <input type="radio" value='1' @if($trabajador->activo == 1) checked @endif name="activo" id="rad6">
                                        <label for="rad6">Activo</label>
                                      </div>
                                      <div class="be-radio has-danger inline baja">
                                        <input type="radio" value='0' @if($trabajador->activo == 0) checked @endif name="activo" id="rad8">
                                        <label for="rad8">Baja</label>
                                      </div>
                                    </div>
                             </div>

                          </div>
                      </div>


                        <div class="col-sm-6 ">
                            <input type="hidden" value="0" id='swga'/>
                        </div>
                    </div>           

                  <div class="row xs-pt-15">
                    <div class="col-xs-6">
                        <div class="be-checkbox">

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <p class="text-center">
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
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });
    </script> 
@stop