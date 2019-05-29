<div class='row reporte'>
    <div class="col-sm-12">
		<h3 class="tituloreporte">{{$titulo}}</h3>
		<p><strong>{{$empresa->descripcion}}</strong> <strong class='fecha'>FECHA : {{$fecha}}</strong></p>
		<p><strong>RUC {{$empresa->ruc}}</strong></p>
		<p><strong>DOMICILIO: {{$empresa->domiciliofiscal1}}</strong></p>
	</div>


  <table id="tablereporte" class="table table-striped table-hover table-fw-widget">
    <thead>
      <tr>
        <th colspan="4" class='center tabladp'>DATOS PERSONALES</th>
        <th colspan="4" class='center tablaho'>HORARIO</th>        
        <th colspan="4" class='center tablamar'>MARCACION</th>                    
      </tr> 

      <tr>
        <th class= 'tabladp'>Nª</th>
        <th class= 'tabladp'>NOMBRES Y APELLIDOS</th>
        <th class= 'tabladp'>AREA</th>
        <th class= 'tabladp'>DNI</th>

        <th class= 'tablaho'>Ent.</th>
        <th class= 'tablaho'>Sal R.</th>
        <th class= 'tablaho'>Ent R.</th> 
        <th class= 'tablaho'>Sal.</th> 
        <th class= 'tablamar'>Ent.</th>
        <th class= 'tablamar'>Sal R.</th>
        <th class= 'tablamar'>Ent R.</th> 
        <th class= 'tablamar'>Sal.</th>

      </tr>
    </thead>
    <tbody>
	  	@foreach($listaasistencia as $index => $item) 
		        <tr>
		        	<td class='negrita'>{{$index + 1}}</td>
		            <td class='negrita'>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                <td class='negrita'>{{$item->trabajador->area->nombre}}</td>
		            <td class='negrita'>{{$item->trabajador->dni}}</td>
                @php
                  $key              =   array_search($item->asistenciatrabajador->$hhorario, array_column($horario, 'id'));
                  $horainicio       =   $horario[$key]['horainicio'];
                  $horafin          =   $horario[$key]['horafin'];
                  $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                  $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                  $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->$diafecha);
                @endphp


                @if ($vacadesc <> '') 
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                  <td class='reportevacadesc' align="center">{{$vacadesc}}</td>
                @else
                  <td>{{$horainicio}}</td>
                  <td>{{$refrigerioinicio}}</td>
                  <td>{{$refrigeriofin}}</td> 
                  <td>{{$horafin}}</td>

                  <td>{{$item->asistenciatrabajador->$mi}}</td>
                  <td>{{$item->asistenciatrabajador->$mri}}</td>
                  <td>{{$item->asistenciatrabajador->$mrf}}</td>
                  <td>{{$item->asistenciatrabajador->$mf}}</td> 
                @endif 

 

		        </tr>       
	  	@endforeach

    </tbody>
  </table>





</div>

<script type="text/javascript">
  $(document).ready(function(){
     App.dataTables();
  });
</script> 