<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {!! Html::style('public/css/excel/excel.css') !!}


    <!-- titulo -->
    <table>
        <tr>
            <td colspan="12"><h1>{{$titulo}}</h1></td>
        </tr>

        <tr>
            <td colspan="12"></td>
        </tr>

        <tr>
            <td class = 'subtitulos' colspan="2">{{$empresa->descripcion}}</td>
            <td width="10"></td>
            <td width="10"></td>
            <td width="10"></td>
            <td width="10"></td>
            <td width="10"></td>
            <td width="10"></td> 
            <td width="10"></td> 
             <td width="10"></td>                       
            <td class = 'subtitulos' colspan="2">FECHA : {{date_format(date_create($fechainicio), 'd-m-Y')}} / {{date_format(date_create($fechafin), 'd-m-Y')}}</td>
        </tr>
        <tr>
            <td class = 'subtitulos' colspan="2">RUC {{$empresa->ruc}}</td>
            <td width="10"></td>
            <td width="10"></td>
            <td width="10"></td>
            <td width="10"></td>
            <td width="10"></td>            
        </tr>
        <tr>
            <td class = 'subtitulos' colspan="8">DOMICILIO: {{$empresa->domiciliofiscal1}}</td>
            <td width="10"></td>
        </tr>
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <th colspan="4" class='titulotabla center tabladp'>DATOS PERSONALES</th>
            <th colspan="4" class='titulotabla center tablaho'>HORARIO</th>        
            <th colspan="4" class='titulotabla center tablaagrupado'>MARCACION</th>    
        </tr>

        <tr>
            <th class= 'tabladp'>FECHA</th>
            <th class= 'tabladp'>NOMBRES Y APELLIDOS</th>
            <th class= 'tabladp'>AREA</th>
            
            <th class= 'tabladp'>DNI</th>

            <th width="5" class= 'titulotabla tablaho'>Ent.</th>
            <th width="50" class= 'titulotabla tablaho'>Sal R.</th>
            <th width="10" class= 'titulotabla tablaho'>Ent R.</th> 
            <th width="10" class= 'titulotabla tablaho'>Sal.</th> 
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


    </table>



</html>
