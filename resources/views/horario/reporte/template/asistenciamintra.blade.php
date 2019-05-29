
    @php
      $nombredia              =   $funcion->funciones->nombredia($fecha);
      $mi                     =   $nombredia.'mi';
      $mf                     =   $nombredia.'mf';
      $mri                    =   $nombredia.'mri';
      $mrf                    =   $nombredia.'mrf';
      $hhorario               =   'h'.$nombredia;
      $diafecha               =   $nombredia.'d';
    @endphp

    <tr>
        <td class='negrita'>{{date_format(date_create($fecha), 'd-m-Y')}}</td>                  
        <td class='negrita'>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
        <td class='negrita'>{{$item->trabajador->area->nombre}}</td>
        <td class='negrita'>{{$item->trabajador->dni}}</td>
        @php
          $key              =   array_search($item->asistenciatrabajador->$hhorario, array_column($horario, 'id'));
          $horainicio       =   $horario[$key]['horainicio'];
          $horafin          =   $horario[$key]['horafin'];
          $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
          $refrigeriofin    =   $horario[$key]['refrigeriofin'];
          $marcacion        =   $horario[$key]['marcacion'];
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

          <td>
            @if ($item->asistenciatrabajador->$mi <> '') 

              @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->$mi) 
                  {{$horainicio}}
              @else
                  {{$item->asistenciatrabajador->$mi}}
              @endif 
            @endif
          </td>
          <td>
            @if ($item->asistenciatrabajador->$mri <> '')
              @if ($marcacion>2)
                @if ($item->asistenciatrabajador->$mri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                    {{$refrigerioinicio}}
                @else
                    {{$item->asistenciatrabajador->$mri}}
                @endif 
              @else
                {{$item->asistenciatrabajador->$mri}}
              @endif                   
            @else
              {{$funcion->funciones->refrigeriosalidamintra($fecha,$item->asistenciatrabajador->$hhorario,'refrigerioinicio',$item->asistenciatrabajador->$mi)}}
            @endif
          </td>
          <td>
            @if ($item->asistenciatrabajador->$mrf <> '') 
              @if ($marcacion>2)
                @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->$mrf) 
                    {{$refrigeriofin}}
                @else
                    {{$item->asistenciatrabajador->$mrf}}
                @endif                    
              @else
                {{$item->asistenciatrabajador->$mrf}}
              @endif
            @else
              {{$funcion->funciones->refrigeriosalidamintra($fecha,$item->asistenciatrabajador->$hhorario,'refrigeriofin',$item->asistenciatrabajador->$mi)}}
            @endif
          </td>
          <td>
            @if ($item->asistenciatrabajador->$mf <> '')

              @if($funcion->funciones->horariofull($item->asistenciatrabajador->$hhorario)) 
                  {{$funcion->funciones->salidamintra($fecha,$item->asistenciatrabajador->$hhorario,'horafin',$item->asistenciatrabajador->$mi,5)}}
              @else
                @if ($item->asistenciatrabajador->$mf > $funcion->funciones->sumarminutos($horafin,15)) 
                    {{$horafin}}
                @else
                    {{$item->asistenciatrabajador->$mf}}
                @endif
              @endif  
            @endif
          </td>
        @endif                                               
    </tr>         
