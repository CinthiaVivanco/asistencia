@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
@stop
@section('section')


	<div class="be-content">
		<div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista de Trabajadores
                  <div class="tools">
                    <a href="{{ url('/agregar-trabajador/'.$idopcion) }}" data-toggle="tooltip" data-placement="top" title="Crear Trabajador">
                      <span class="icon mdi mdi-plus-circle-o"></span>
                    </a>
                  </div>
                </div>
                <div class="panel-body">

                  <table id="table1" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>Dni</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>                     
                        <th>Nombres</th>
                        <th>Empresa</th>
                        <th>Área</th> 
                        <th>Horario</th> 
                        <th>Opción</th>
                      </tr>
                    </thead>

                  @foreach($listatrabajadores as $item)

                    @if($item->activo == 1) 
                        <tr>
                            <td>{{$item->dni}} </td>
                            <td>{{$item->apellidopaterno}}</td>
                            <td>{{$item->apellidomaterno}}</td>
                            <td>{{$item->nombres}}</td>
                            <td>{{$item->local->empresa->descripcion}}</td>
                            <td>{{$item->area->nombre}}</td>
                            <td>{{$item->horario->nombre}}</td>
                            <td class="rigth">
                              <div class="btn-group btn-hspace">
                                <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                <ul role="menu" class="dropdown-menu pull-right">
                                  <li>
                                    <a href="{{ url('/modificar-trabajador/'.$idopcion.'/'.Hashids::encode(substr($item->id, -12))) }}">
                                      Modificar
                                    </a>
                                    <a href="{{ url('/baja-trabajador/'.$idopcion.'/'.Hashids::encode(substr($item->id, -12))) }}">
                                      Baja
                                    </a>
                                    
                                  </li>
                                </ul>
                              </div>
                            </td>
                        </tr>   
                     @endif      
                  @endforeach

                    </tbody>
                  </table>
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
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>

  <script src="{{ asset('public/js/personal/personal.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script> 
@stop