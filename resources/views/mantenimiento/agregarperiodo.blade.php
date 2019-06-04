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

        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">PERIODO<span class="panel-subtitle">Crear un nuevo Periodo</span></div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/agregar-periodo/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}

              <div class="row">
                  <div class="col-sm-6 leftperiodo">        
                      <div class="panel-body">
                        <div class="form-group ">
                          <label class="col-sm-12 control-label labelleft" >Año:</label>
                          <div class="col-sm-7">
                           <input  type="text"
                                id="anio" name='anio' value="@if(isset($periodo)){{old('anio' ,$periodo->anio)}}@else{{old('anio')}}@endif" placeholder="Año"
                                required = "" class="form-control input-sm " data-parsley-type="number"
                                autocomplete="off" data-aw="2"/>

                          @include('error.erroresvalidate', [ 'id' => $errors->has('anio')  , 
                                                              'error' => $errors->first('anio', ':message') , 
                                                              'data' => '2'])
          
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-12 control-label labelleft">Código:</label>
                          <div class="col-sm-7">
                            <input  type="text"
                                  id="codigo" name='codigo' value="@if(isset($periodo)){{old('codigo' ,$periodo->codigo)}}@else{{old('codigo')}}@endif" placeholder="Código"
                                  class="form-control input-sm" autocomplete="off" data-aw="2"/>

                                @include('error.erroresvalidate', [ 'id' => $errors->has('codigo')  , 
                                                                    'error' => $errors->first('codigo', ':message') , 
                                                                    'data' => '2'])
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="panel-body">
                      <div class="form-group meses">
                        <label class="col-sm-12 control-label labelleft" >Mes:</label>
                        <div class="col-sm-7" >
                          {!! Form::select( 'mes_id', $combomes, array(),
                                            [
                                              'class'       => 'form-control control input-sm mesperiodo' ,
                                              'id'          => 'mes_id',
                                              'required'    => '',
                                              'data-aw'     => '1',
                                            ]) !!}
                        </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-12 control-label labelleft">Descripción:</label>
                          <div class="col-sm-7">
                            <input  type="text"
                                  id="descripcion" name='descripcion' value="@if(isset($periodo)){{old('descripcion' ,$periodo->descripcion)}}@else{{old('descripcion')}}@endif" placeholder="Descripción"
                                  class="form-control input-sm" autocomplete="off" data-aw="2"/>

                                 @include('error.erroresvalidate', [ 'id' => $errors->has('descripcion')  , 
                                                                'error' => $errors->first('descripcion', ':message') , 
                                                                'data' => '2'])
                          </div>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row xs-pt-15">
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




