<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Planillas">
    <meta name="author" content="Cinthia Vivanco Gonzales">
    <link rel="icon" href="{{ asset('public/img/icono/faviind.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/alfasweb.css') }} "/>

    <title>MARCACION INDUAMERICA</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/font-awesome.min.css') }} "/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/style.css') }} "/>
    <link rel="stylesheet" href="{{ asset('public/css/marcacion.css?v='.$version) }}" type="text/css"/>

  </head>
  <body>

        @include('success.ajax-alert')
        <div class="row">
            <div class="col-md-6">
            <ul id="clock"> 
                <li id="sec"></li>
                <li id="hour"></li>
              <li id="min"></li>
            </ul>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="panel-body">
                        <div class="form-group ">
                            <div class="form-group">
                              <label class="col-sm-7 control-label labelleft input-lg labeldni">COLOQUE SU DNI :</label>
                              <div class="col-sm-7 abajocaja">

                                <input  type="text"
                                        id="dni" 
                                        name='dni' 
                                        placeholder="DNI"
                                        required = "" 
                                        class="form-control input-lg validarnumero dnivalida" 
                                        data-parsley-type="number"
                                        maxlength="8"
                                        autocomplete="off" 
                                        data-aw="2"/>

                              </div>
                            </div>
                        </div>
                    </div>          
                </div> 
                <div class="col-md-12">
                    <div id= 'ajaxmensaje'>
                        <div class="panel-body">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Estado</th>
                                <th>Nombre</th>
                              </tr>
                            </thead>
                            <tbody>

                              @foreach($asistenciadiaria as $item)
                              <tr class="@if($item->estadoaviso == 'Entrada' or $item->estadoaviso == 'Salida') success  @else primary @endif">
                                <td >{{$item->estadoaviso}}</td>
                                <td>{{$item->alias}}</td>
                              </tr>                              
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>                  
                </div>                  



            </div>      
        </div>
        <input type='hidden' id='carpeta' value="{{$capeta}}"/>
        <input type="text" id="token" name="_token"  value="{{ csrf_token() }}"> 

  </body>

    <script src="{{ asset('public/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/general.js?v='.$version) }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        App.init();
        $('form').parsley();
      });
    </script>

    <script src="{{ asset('public/js/marcacion/marcacion.js?v='.$version) }}" type="text/javascript"></script>


</html>