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
    		
    </header>
    <section>
        <article>
          <table>
            <tr>
              <th class='fila center'>Trabajador</th>
              <th class='fila center'>Lunes</th>
              <th class='fila center'>Martes</th>
              <th class='fila center'>Miercoles</th>
              <th class='fila center'>Jueves</th>
              <th class='fila center'>Viernes</th>
              <th class='fila center'>Sabado</th>
              <th class='fila center'>Domingo</th>              
            </tr>

            @foreach($listahorario as $item)
                <tr>
                    <td class='fila'>

                        {{$item->trabajador->nombres}} {{$item->trabajador->apellidopaterno}} {{$item->trabajador->apellidomaterno}}

                    </td>
                    <td class='fila center'>

                        @if ($item->luh == 1) 

                            <!--HORARIO-->
                            @php
                                $key = array_search($item->hlu, array_column($horario, 'id'))
                            @endphp

                            <p class='subtitulo'>HORARIO </p>
                            <p class='fecha'>{{date_format(date_create($item->lud), 'd/m/Y')}}</p>
                            <p>{{$horario[$key]['nombre']}}</p>
                            <p class='hora'>{{$item->rhlu}}</p>

                            <!--ASISTENCIA-->
                            <p class='subtitulo asistencia'>ASISTENCIA </p>
                            @if ($item->asistenciatrabajador->lumi == '')
                                <p>No marco</p>
                            @else
                                <p>Entrada  {{$item->asistenciatrabajador->lumi}}</p>
                                <p>Salida   {{$item->asistenciatrabajador->lumf}}</p>
                            @endif

                        @else 
                            <p class='punto noasistio'></p> 
                        @endif
                   
                    </td>
                    <td class='fila center'>
                        
                        @if ($item->mah == 1) 

                            <!--HORARIO-->
                            @php
                                $key = array_search($item->hma, array_column($horario, 'id'))
                            @endphp

                            <p class='subtitulo'>HORARIO </p>                        
                            <p class='fecha'>{{date_format(date_create($item->mad), 'd/m/Y')}}</p>
                            <p>{{$horario[$key]['nombre']}}</p>
                            <p class='hora'>{{$item->rhma}}</p>

                            <!--ASISTENCIA--> 
                            <p class='subtitulo asistencia'>ASISTENCIA </p>
                            @if ($item->asistenciatrabajador->mami == '')
                                <p>No marco</p>
                            @else
                                <p>Entrada  {{$item->asistenciatrabajador->mami}}</p>
                                <p>Salida   {{$item->asistenciatrabajador->mamf}}</p>
                            @endif
                                                      
                        @else 
                            <p class='punto noasistio'></p> 
                        @endif
                   
                    </td>
                    <td class='fila center'>
                        
                        @if ($item->mih == 1) 

                            @php
                                $key = array_search($item->hmi, array_column($horario, 'id'))
                            @endphp

                            <p class='subtitulo'>HORARIO </p>  
                            <p class='fecha'>{{date_format(date_create($item->mid), 'd/m/Y')}}</p>
                            <p>{{$horario[$key]['nombre']}}</p>
                            <p class='hora'>{{$item->rhmi}}</p> 
                            <p class='subtitulo asistencia'>ASISTENCIA </p>
                            @if ($item->asistenciatrabajador->mimi == '')
                                <p>No marco</p>
                            @else
                                <p>Entrada  {{$item->asistenciatrabajador->mimi}}</p>
                                <p>Salida   {{$item->asistenciatrabajador->mimf}}</p>
                            @endif
                                                        
                        @else 
                            <p class='punto noasistio'></p> 
                        @endif
                   
                    </td>
                    <td class='fila center'>

                        @if ($item->juh == 1) 

                            @php
                                $key = array_search($item->hju, array_column($horario, 'id'))
                            @endphp

                            <p class='subtitulo'>HORARIO </p>
                            <p class='fecha'>{{date_format(date_create($item->jud), 'd/m/Y')}}</p>
                            <p>{{$horario[$key]['nombre']}}</p>
                            <p class='hora'>{{$item->rhju}}</p> 
                            <p class='subtitulo asistencia'>ASISTENCIA </p>
                            @if ($item->asistenciatrabajador->jumi == '')
                                <p>No marco</p>
                            @else
                                <p>Entrada  {{$item->asistenciatrabajador->jumi}}</p>
                                <p>Salida   {{$item->asistenciatrabajador->jumf}}</p>
                            @endif
                         
                        @else 
                            <p class='punto noasistio'></p> 
                        @endif
                   
                    </td>
                    <td class='fila center'>
                        
                        @if ($item->vih == 1) 

                            @php
                                $key = array_search($item->hvi, array_column($horario, 'id'))
                            @endphp

                            <p class='subtitulo'>HORARIO </p>
                            <p class='fecha'>{{date_format(date_create($item->vid), 'd/m/Y')}}</p>
                            <p>{{$horario[$key]['nombre']}}</p>
                            <p class='hora'>{{$item->rhvi}}</p> 
                            <p class='subtitulo asistencia'>ASISTENCIA </p>
                            @if ($item->asistenciatrabajador->vimi == '')
                                <p>No marco</p>
                            @else
                                <p>Entrada  {{$item->asistenciatrabajador->vimi}}</p>
                                <p>Salida   {{$item->asistenciatrabajador->vimf}}</p>
                            @endif
                          
                        @else 
                            <p class='punto noasistio'></p> 
                        @endif
                   
                    </td>
                    <td class='fila center'>
                        
                        @if ($item->sah == 1) 

                            @php
                                $key = array_search($item->hsa, array_column($horario, 'id'))
                            @endphp

                            <p class='subtitulo'>HORARIO </p>
                            <p class='fecha'>{{date_format(date_create($item->sad), 'd/m/Y')}}</p>
                            <p>{{$horario[$key]['nombre']}}</p>
                            <p class='hora'>{{$item->rhsa}}</p> 
                            <p class='subtitulo asistencia'>ASISTENCIA </p>
                            @if ($item->asistenciatrabajador->sami == '')
                                <p>No marco</p>
                            @else
                                <p>Entrada  {{$item->asistenciatrabajador->sami}}</p>
                                <p>Salida   {{$item->asistenciatrabajador->samf}}</p>
                            @endif
                         
                        @else 
                            <p class='punto noasistio'></p> 
                        @endif
                   
                    </td>
                    <td class='fila center'>
                        
                        @if ($item->doh == 1) 

                            @php
                                $key = array_search($item->hdo, array_column($horario, 'id'))
                            @endphp

                            <p class='subtitulo'>HORARIO </p>
                            <p class='fecha'>{{date_format(date_create($item->dod), 'd/m/Y')}}</p>
                            <p>{{$horario[$key]['nombre']}}</p>
                            <p class='hora'>{{$item->rhdo}}</p>
                            <p class='subtitulo asistencia'>ASISTENCIA </p>
                            @if ($item->asistenciatrabajador->domi == '')
                                <p>No marco</p>
                            @else
                                <p>Entrada  {{$item->asistenciatrabajador->domi}}</p>
                                <p>Salida   {{$item->asistenciatrabajador->domf}}</p>
                            @endif
                                                      
                        @else 
                            <p class='punto noasistio'></p> 
                        @endif
                   
                    </td>                    
                </tr>
            @endforeach         



          </table>

        </article>

    </section>

</body>
</html>