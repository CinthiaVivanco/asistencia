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
            <td class = 'subtitulos' colspan="2">FECHA : {{$fecha}}</td>
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
            <th colspan="4" class='titulotabla center tablamar'>MARCACIÓN</th>    
        </tr>

        <tr>
            <th class= 'tabladp'>Nª</th>
            <th class= 'tabladp'>NOMBRES Y APELLIDOS</th>
            <th class= 'tabladp'>AREA</th>
            <th class= 'tabladp'>DNI</th>

            <th width="5" class= 'titulotabla tablaho'>Ent.</th>
            <th width="50" class= 'titulotabla tablaho'>Sal R.</th>
            <th width="10" class= 'titulotabla tablaho'>Ent R.</th> 
            <th width="10" class= 'titulotabla tablaho'>Sal.</th> 
            <th width="10" class= 'titulotabla tablamar'>Ent.</th>
            <th width="10" class= 'titulotabla tablamar'>Sal R.</th>
            <th width="10" class= 'titulotabla tablamar'>Ent R.</th> 
            <th width="10" class= 'titulotabla tablamar'>Sal.</th> 
                 
        </tr>

        @foreach($listaasistencia as $index => $item) 
                <tr>
                    <td width="5" class= 'negrita'>{{$index + 1}}</td>
                    <td width="50" class= 'negrita'> {{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td width="10" class= 'negrita'>{{$item->trabajador->area->nombre}}</td>
                    <td width="10" class= 'negrita'>{{$item->trabajador->dni}}</td>

                    @php
                      $key              =   array_search($item->asistenciatrabajador->$hhorario, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->$diafecha);
                    @endphp


                    @if ($vacadesc <> '') 
                        <td class='reportevacadesc'>{{$vacadesc}}</td>
                        <td class='reportevacadesc'>{{$vacadesc}}</td>
                        <td class='reportevacadesc'>{{$vacadesc}}</td>
                        <td class='reportevacadesc'>{{$vacadesc}}</td>
                        <td class='reportevacadesc'>{{$vacadesc}}</td>
                        <td class='reportevacadesc'>{{$vacadesc}}</td>
                        <td class='reportevacadesc'>{{$vacadesc}}</td>
                        <td class='reportevacadesc'>{{$vacadesc}}</td>                        
                    @else
                        <td width="10">{{$horainicio}}</td>
                        <td width="10">{{$refrigerioinicio}}</td>
                        <td width="10">{{$refrigeriofin}}</td> 
                        <td width="10">{{$horafin}}</td>


                        <td width="10">{{$item->asistenciatrabajador->$mi}}</td>
                        <td width="10">{{$item->asistenciatrabajador->$mri}}</td>
                        <td width="10">{{$item->asistenciatrabajador->$mrf}}</td>
                        <td width="10">{{$item->asistenciatrabajador->$mf}}</td> 
                    @endif                                                                    
                </tr>       
        @endforeach




    </table>



</html>
