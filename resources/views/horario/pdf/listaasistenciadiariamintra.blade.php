<!DOCTYPE html>
<html lang="es">

<head>
  <title>{{$titulo}}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}"> 
  <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pdf.css') }} "/>

</head>
<body>
    <header>
      <div class='reporte'>
        <h3 class="center titulo">{{$titulo}}</h3>
        <p class="subtitulo">
          <strong>{{$empresa->descripcion}}</strong> 
          <strong class='fecha'>FECHA : {{date_format(date_create($fechainicio), 'd-m-Y')}} / {{date_format(date_create($fechafin), 'd-m-Y')}}</strong>
        </p>
        <p class="subtitulo"><strong>RUC {{$empresa->ruc}}</strong></p>
        <p class="subtitulo"><strong>DOMICILIO: {{$empresa->domiciliofiscal1}}</strong></p>
      </div>
    </header>
    <section>
        <article>
          <table>
            <tr>
                <th colspan="4" class='titulotabla center tabladp'>DATOS PERSONALES</th>     
                <th colspan="4" class='titulotabla center tablaagrupado'>MARCACION</th>    
            </tr>

            <tr>
                <th class= 'tabladp'>FECHA</th>
                <th class= 'tabladp'>NOMBRES Y APELLIDOS</th>
                <th class= 'tabladp'>AREA</th>
                <th class= 'tabladp'>DNI</th>
                <th width="10" class= 'titulotabla tablaagrupado'>Ent.</th>
                <th width="10" class= 'titulotabla tablaagrupado'>Sal R.</th>
                <th width="10" class= 'titulotabla tablaagrupado'>Ent R.</th> 
                <th width="10" class= 'titulotabla tablaagrupado'>Sal.</th> 
                     
            </tr>

            @foreach($trabajador as $itemt) 
            @php
              $listaasistencia        =   $funcion->funciones->reportemintra($itemt->id,$arraysemanas)
            @endphp

              @foreach($listaasistencia as $index => $item) 

                @php
                  $fecha                  =   $item->asistenciatrabajador->lud;
                @endphp
                @if($fecha >= $fechainicio && $fecha <= $fechafin)
                    @include('horario.reporte.template.asistenciamintrapdf', 
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

                    @include('horario.reporte.template.asistenciamintrapdf', 
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

                    @include('horario.reporte.template.asistenciamintrapdf', 
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

                    @include('horario.reporte.template.asistenciamintrapdf', 
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

                    @include('horario.reporte.template.asistenciamintrapdf', 
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

                    @include('horario.reporte.template.asistenciamintrapdf', 
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

                    @include('horario.reporte.template.asistenciamintrapdf', 
                            [
                            'item' => $item ,
                            'index' => $index,
                            'fecha' => $fecha
                            ])
                @endif

              @endforeach

            @endforeach


          </table>
        </article>
    </section>
</body>
</html>