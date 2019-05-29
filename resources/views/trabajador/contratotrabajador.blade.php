@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/personal/contrato.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootsnipp.css') }} "/>

    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/scrollbar/scrollbar.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-select/css/bootstrap-select.min.css') }} "/>


@stop
@section('section')

<div class="be-content ajaxpersonal">
  <div class="main-content container-fluid">

    <h2 class="panel-heading">Contrato del Trabajador :  {{$trabajador->apellidopaterno}} {{$trabajador->apellidomaterno}} {{$trabajador->nombres}}</h2>
  </div>

  <div class="container">
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content ajax-modal">


        </div>
      </div>
    </div>
  </div>

  <div class="main-content container-fluid editc">
    
    <div class="row">

      @foreach($listacontrato as $item)

        <div class="col-sm-4 container listacontrato @if($item->estado == 1) activo @else concluido @endif"">
            <div class="row">
             <div class="cont_princ_lists">
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 estilo ">
                <div class="offer offer-success cont_princ_lists estilo1" >
                  
                  <div class="shape">
                    <div class="shape-text">
                      act            
                    </div>
                  </div>

                  <div class="offer-content">
                    <h3 class="lead">
                     Contrato
                    </h3>           
                    <p>
                     Desde: {{date_format(date_create($item->fechainicio),'d-m-Y')}} Hasta: 
                     @if($item->fechafin <> '1900-01-01')
                        {{date_format(date_create($item->fechafin),'d-m-Y')}}
                     @endif

 
                      <br> 
                    </p>
                  </div>



                  <div class="col-sm-2 detver"> 
                    <div class="icon icono">
                          <span
                            data-toggle="modal" 
                            data-target="#myModal"           
                            class="fa fa-eye" 
                            id='btnverc'
                            name='{{$item->id}}' 
                            data_opcion='{{$idopcion}}'
                            data_trabajador='{{Hashids::encode(substr($trabajador->id, -12))}}'>
                          </span> 
                    </div>
                  </div>

                  <div class="col-sm-2 detmodificar"> 
                    <div class="icon icono">
                          <span                                     
                          class="fa fa-pencil" 
                          id='btnmodificarc'
                          name='{{$item->id}}' 
                          data_opcion='{{$idopcion}}'
                          data_trabajador='{{Hashids::encode(substr($trabajador->id, -12))}}'
                          ></span>
                    </div>
                  </div>

                  <div class="row content ">
                    <div class="col-md-12">
                      <div class="panel-heading">

                        <div class="tools toolsopcion">
                          <a href="{{url('/contrato-trabajador-pdf/'.Hashids::encode(substr($item->id, -12)))}}" target="_blank" data-toggle="tooltip" id="descargarcontrato" data-placement="top" title="">
                              <span class="icon mdi mdi-collection-pdf icono"></span>
                          </a>

                        </div>
                      </div>
                     </div>
                  </div>
                  
                </div>
              </div>
            </div>
            </div>
        </div>

                 
    @endforeach

    </div>
  </div>


  <div class="main-content container-fluid">
    <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading panel-heading-divider" >Contrato<span class="panel-subtitle">Crear el Contrato</span></div>
              
              <div class="panel-body">

                <div class="main-content container-fluid ajaxformc">

                  <form method="POST" action="{{ url('/ficha-contrato-trabajador/'.$idopcion.'/'.Hashids::encode(substr($trabajador->id, -12))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed"> 
                                    {{ csrf_field() }}
                        @include('trabajador.form.contrato')
                  </form>

                
              </div>
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


    <script type="text/javascript">
      $(document).ready(function(){  

        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
    });

    </script> 
    <script src="{{ asset('public/js/contrato/contrato.js') }}" type="text/javascript"></script>
@stop