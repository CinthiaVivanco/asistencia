<div class='row reporte'>
  <div class="col-sm-12">
    <h3 class="tituloreporte">{{$titulo}}</h3>
    <p><strong>{{$empresa->descripcion}}</strong> 
    <strong class='fecha'>FECHA : {{date_format(date_create($fechainicio), 'd-m-Y')}} / {{date_format(date_create($fechafin), 'd-m-Y')}}</strong></p>
    <p><strong>RUC {{$empresa->ruc}}</strong></p>
    <p><strong>DOMICILIO: {{$empresa->domiciliofiscal1}}</strong></p>
  </div>


  <table id="tablereporte" class="table table-striped table-hover table-fw-widget">
    <thead>
      <tr>
        <th colspan="4" class='center tabladp'>DATOS PERSONALES</th>
        <th colspan="4" class='center tablaho'>HORARIO</th>        
        <th colspan="4" class='center tablaagrupado'>MARCACION</th>
                    
      </tr> 

      <tr>
        <th class= 'tabladp'>FECHA</th>        
        <th class= 'tabladp'>NOMBRES Y APELLIDOS</th>
        <th class= 'tabladp'>AREA</th>
        <th class= 'tabladp'>DNI</th>

        <th class= 'tablaho'>Ent.</th>
        <th class= 'tablaho'>Sal R.</th>
        <th class= 'tablaho'>Ent R.</th> 
        <th class= 'tablaho'>Sal.</th> 
        <th class= 'tablaagrupado'>Ent.</th>
        <th class= 'tablaagrupado'>Sal R.</th>
        <th class= 'tablaagrupado'>Ent R.</th> 
        <th class= 'tablaagrupado'>Sal.</th>
      </tr>
    </thead>
    <tbody>

      @foreach($trabajador as $itemt) 
      @php
        $listaasistencia        =   $funcion->funciones->reportemintra($itemt->id,$arraysemanas)
      @endphp
        @foreach($listaasistencia as $index => $item) 

          @php
            $fecha                  =   $item->asistenciatrabajador->lud;
          @endphp
          @if($fecha >= $fechainicio && $fecha <= $fechafin)
              @include('horario.reporte.template.asistenciamintra', 
                      [
                      'item' => $item ,
                      'index' => $index,
                      'fecha' => $fecha
                      ])
          @endif


          @php
            $fecha                  =   $item->asistenciatrabajador->mad;
          @endphp
          @if($fecha >= $fechainicio && $fecha <= $fechafin)

              @include('horario.reporte.template.asistenciamintra', 
                      [
                      'item' => $item ,
                      'index' => $index,
                      'fecha' => $fecha
                      ])
          @endif

          @php
            $fecha                  =   $item->asistenciatrabajador->mid;
          @endphp
          @if($fecha >= $fechainicio && $fecha <= $fechafin)

              @include('horario.reporte.template.asistenciamintra', 
                      [
                      'item' => $item ,
                      'index' => $index,
                      'fecha' => $fecha
                      ])
          @endif


          @php
            $fecha                  =   $item->asistenciatrabajador->jud;
          @endphp
          @if($fecha >= $fechainicio && $fecha <= $fechafin)

              @include('horario.reporte.template.asistenciamintra', 
                      [
                      'item' => $item ,
                      'index' => $index,
                      'fecha' => $fecha
                      ])
          @endif


          @php
            $fecha                  =   $item->asistenciatrabajador->vid;
          @endphp
          @if($fecha >= $fechainicio && $fecha <= $fechafin)

              @include('horario.reporte.template.asistenciamintra', 
                      [
                      'item' => $item ,
                      'index' => $index,
                      'fecha' => $fecha
                      ])
          @endif


          @php
            $fecha                  =   $item->asistenciatrabajador->sad;
          @endphp
          @if($fecha >= $fechainicio && $fecha <= $fechafin)

              @include('horario.reporte.template.asistenciamintra', 
                      [
                      'item' => $item ,
                      'index' => $index,
                      'fecha' => $fecha
                      ])
          @endif


          @php
            $fecha                  =   $item->asistenciatrabajador->dod;
          @endphp
          @if($fecha >= $fechainicio && $fecha <= $fechafin)

              @include('horario.reporte.template.asistenciamintra', 
                      [
                      'item' => $item ,
                      'index' => $index,
                      'fecha' => $fecha
                      ])
          @endif

        @endforeach
      @endforeach
    </tbody>
  </table>

</div>

<script type="text/javascript">
  $(document).ready(function(){
     App.dataTables();
  });
</script> 