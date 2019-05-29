<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	{!! Html::style('public/css/excel/excel.css') !!}

    <!-- titulo -->
    <table>

        <tr>
            <th class= 'tabladp'>NOMBRES Y APELLIDOS</th>
            <th class= 'tabladp'>DNI</th>
            @for ($i = 0; $i < count($listadias); $i++)
                <th class= 'tablaho'>{{date_format(date_create($listadias[$i]), 'd')}}</th>
            @endfor
            <th class= 'tabladp'>COUNT</th>
        </tr>

    <tbody>

        @foreach($listapiloto as $index => $item) 
            @php
                $count      =  0;
            @endphp
                <tr>
                    <td width="50" class= 'negrita'> {{$item->NombreCompleto}} </td>
                    <td width="10" class= 'negrita'>{{$item->Dni}}</td>
                    @for ($i = 0; $i < count($listadias); $i++)                                                                    
                        <td width="3" class= 'negrita'>
                            @if($funcion->funciones->asistencia_conductor($listadias[$i],$item->Id,$idplanillapiloto,$listaviajes))
                                A
                            @php  $count  =  $count  +  1; @endphp 
                            @endif
                        </td>
                    @endfor
                    <td width="10" class= 'negrita'>{{$count}}</td>
        @endforeach




    </table>



</html>
