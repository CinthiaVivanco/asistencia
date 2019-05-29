
<div class='row reporte'>
  <div class="col-sm-12">
    <h3 class="tituloreporte">{{$titulo}}</h3>
    <p class='subtitulos'><strong>Datos de la Empresa</strong></p>
    <p class='contenidost'>Nombre de la Empresa : {{$empresa->descripcion}}</p>
    <p class='contenidost'>Ruc : {{$empresa->ruc}}</p>
    <p class='contenidost'>Dirección : {{$empresa->domiciliofiscal1}}</p>

  </div>


  <table id="tablereporte" class="table table-striped table-hover table-fw-widget">
    <thead>


      <tr>
        <th>Fecha del dia</th>
        <th>Trabajador</th>
        <th>Area</th>              
        <th>Ing.</th>
        <th>Ref. Ini.</th>
        <th>Ref. Ter.</th>
        <th>Sal.</th>

        <th>Sobretiempo</th>
        <th>Tardanzas</th>
        <th>Justificadas</th>
        <th>Injustificadas</th> 

      </tr>
    </thead>
    <tbody>


      @php
        $sobretiempo          =   0;
        $tardanza             =   0;     
      @endphp

      @foreach($trabajador as $itemt) 
      @php
        $listaasistencia        =   $funcion->funciones->reporteindividual($itemt->id,$arraysemanas)
      @endphp
        @foreach($listaasistencia as $index => $item) 

          @if($item->asistenciatrabajador->lud >= $fechainicio && $item->asistenciatrabajador->lud <= $fechafin)
            @if($item->luh == 1)
                <tr>
                  <td>{{date_format(date_create($item->asistenciatrabajador->lud), 'd-m-Y')}}</td>
                  <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                  <td>{{$itemt->area->nombre}}</td>                  
                  <td>{{$item->asistenciatrabajador->lumi}}</td>
                  <td>{{$item->asistenciatrabajador->lumri}}</td>
                  <td>{{$item->asistenciatrabajador->lumrf}}</td>
                  <td>{{$item->asistenciatrabajador->lumf}}</td>

                  @php
                    $key              =   array_search($item->asistenciatrabajador->hlu, array_column($horario, 'id'));
                    $horainicio       =   $horario[$key]['horainicio'];
                    $horafin          =   $horario[$key]['horafin'];
                    $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                    $minutos          =   0;
                  @endphp

                  @if($item->asistenciatrabajador->lumi <> '' && $item->asistenciatrabajador->lumi < $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($item->asistenciatrabajador->lumi,$horainicio) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @if($item->asistenciatrabajador->lumf <> '' && $item->asistenciatrabajador->lumf > $horafin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horafin,$item->asistenciatrabajador->lumf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $sobretiempo  =   $sobretiempo + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>


                  @php $minutos =   0; @endphp
                  @if($item->asistenciatrabajador->lumi <> '' && $item->asistenciatrabajador->lumi > $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horainicio ,$item->asistenciatrabajador->lumi) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @if($item->asistenciatrabajador->lumrf <> '' && $item->asistenciatrabajador->lumrf > $refrigeriofin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($refrigeriofin,$item->asistenciatrabajador->lumrf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $tardanza  =   $tardanza + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>

                  <td>x</td>
                  <td>x</td>                               
                </tr>
            @else
                @php
                    $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->lud);
                @endphp
                  @if ($vacadesc <> '')
                    <tr>
                      <td>{{date_format(date_create($item->asistenciatrabajador->lud), 'd-m-Y')}}</td>
                      <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                      <td>{{$itemt->area->nombre}}</td>  
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                    </tr>
                  @endif
            @endif

          @endif

          @if($item->asistenciatrabajador->mad >= $fechainicio && $item->asistenciatrabajador->mad <= $fechafin)
            @if($item->mah == 1)
                <tr>
                  <td>{{date_format(date_create($item->asistenciatrabajador->mad), 'd-m-Y')}}</td>
                  <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                  <td>{{$itemt->area->nombre}}</td>                    
                  <td>{{$item->asistenciatrabajador->mami}}</td>
                  <td>{{$item->asistenciatrabajador->mamri}}</td>
                  <td>{{$item->asistenciatrabajador->mamrf}}</td>
                  <td>{{$item->asistenciatrabajador->mamf}}</td>

                  @php
                    $key              =   array_search($item->asistenciatrabajador->hma, array_column($horario, 'id'));
                    $horainicio       =   $horario[$key]['horainicio'];
                    $horafin          =   $horario[$key]['horafin'];
                    $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                    $minutos          =   0;
                  @endphp
                  @if($item->asistenciatrabajador->mami <> '' && $item->asistenciatrabajador->mami < $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($item->asistenciatrabajador->mami,$horainicio) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @if($item->asistenciatrabajador->mamf <> '' && $item->asistenciatrabajador->mamf > $horafin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horafin,$item->asistenciatrabajador->mamf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $sobretiempo  =   $sobretiempo + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>


                  @php $minutos =   0; @endphp
                  @if($item->asistenciatrabajador->mami <> '' && $item->asistenciatrabajador->mami > $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horainicio ,$item->asistenciatrabajador->mami) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @if($item->asistenciatrabajador->mamrf <> '' && $item->asistenciatrabajador->mamrf > $refrigeriofin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($refrigeriofin,$item->asistenciatrabajador->mamrf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $tardanza  =   $tardanza + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>
                  <td>x</td>
                  <td>x</td>                               
                </tr> 
            @else
                @php
                    $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->mad);
                @endphp
                  @if ($vacadesc <> '')
                    <tr>
                      <td>{{date_format(date_create($item->asistenciatrabajador->mad), 'd-m-Y')}}</td>
                      <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                      <td>{{$itemt->area->nombre}}</td>                     
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                    </tr>
                  @endif
            @endif
          @endif

          @if($item->asistenciatrabajador->mid >= $fechainicio && $item->asistenciatrabajador->mid <= $fechafin)
            @if($item->mih == 1)
                <tr>
                  <td>{{date_format(date_create($item->asistenciatrabajador->mid), 'd-m-Y')}}</td>
                  <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                  <td>{{$itemt->area->nombre}}</td>                    
                  <td>{{$item->asistenciatrabajador->mimi}}</td>
                  <td>{{$item->asistenciatrabajador->mimri}}</td>
                  <td>{{$item->asistenciatrabajador->mimrf}}</td>
                  <td>{{$item->asistenciatrabajador->mimf}}</td>

                  @php
                    $key              =   array_search($item->asistenciatrabajador->hmi, array_column($horario, 'id'));
                    $horainicio       =   $horario[$key]['horainicio'];
                    $horafin          =   $horario[$key]['horafin'];
                    $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                    $minutos          =   0;
                  @endphp
                  @if($item->asistenciatrabajador->mimi <> '' && $item->asistenciatrabajador->mimi < $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($item->asistenciatrabajador->mimi,$horainicio) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @if($item->asistenciatrabajador->mimf <> '' && $item->asistenciatrabajador->mimf > $horafin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horafin,$item->asistenciatrabajador->mimf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $sobretiempo  =   $sobretiempo + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>


                  @php $minutos =   0; @endphp
                  @if($item->asistenciatrabajador->mimi <> '' && $item->asistenciatrabajador->mimi > $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horainicio ,$item->asistenciatrabajador->mimi) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @if($item->asistenciatrabajador->mimrf <> '' && $item->asistenciatrabajador->mimrf > $refrigeriofin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($refrigeriofin,$item->asistenciatrabajador->mimrf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $tardanza  =   $tardanza + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>


                  <td>x</td>
                  <td>x</td>                               
                </tr> 
            @else
                @php
                    $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->mid);
                @endphp
                  @if ($vacadesc <> '')
                    <tr>
                      <td>{{date_format(date_create($item->asistenciatrabajador->mid), 'd-m-Y')}}</td>
                      <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                      <td>{{$itemt->area->nombre}}</td>                     
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                    </tr>
                  @endif
            @endif 
          @endif

          @if($item->asistenciatrabajador->jud >= $fechainicio && $item->asistenciatrabajador->jud <= $fechafin)
            @if($item->juh == 1)
                <tr>
                  <td>{{date_format(date_create($item->asistenciatrabajador->jud), 'd-m-Y')}}</td>
                  <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                  <td>{{$itemt->area->nombre}}</td>                    
                  <td>{{$item->asistenciatrabajador->jumi}}</td>
                  <td>{{$item->asistenciatrabajador->jumri}}</td>
                  <td>{{$item->asistenciatrabajador->jumrf}}</td>
                  <td>{{$item->asistenciatrabajador->jumf}}</td>

                  @php
                    $key              =   array_search($item->asistenciatrabajador->hju, array_column($horario, 'id'));
                    $horainicio       =   $horario[$key]['horainicio'];
                    $horafin          =   $horario[$key]['horafin'];
                    $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                    $minutos          =   0;
                  @endphp
                  @if($item->asistenciatrabajador->jumi <> '' && $item->asistenciatrabajador->jumi < $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($item->asistenciatrabajador->jumi,$horainicio) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @if($item->asistenciatrabajador->jumf <> '' && $item->asistenciatrabajador->jumf > $horafin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horafin,$item->asistenciatrabajador->jumf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @php $sobretiempo  =   $sobretiempo + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>



                  @php $minutos =   0; @endphp
                  @if($item->asistenciatrabajador->jumi <> '' && $item->asistenciatrabajador->jumi > $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horainicio ,$item->asistenciatrabajador->jumi) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @if($item->asistenciatrabajador->jumrf <> '' && $item->asistenciatrabajador->jumrf > $refrigeriofin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($refrigeriofin,$item->asistenciatrabajador->jumrf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $tardanza  =   $tardanza + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>


                  <td>x</td>
                  <td>x</td>                               
                </tr> 
            @else
                @php
                    $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->jud);
                @endphp
                  @if ($vacadesc <> '')
                    <tr>
                      <td>{{date_format(date_create($item->asistenciatrabajador->jud), 'd-m-Y')}}</td>
                      <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                      <td>{{$itemt->area->nombre}}</td>                    
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                    </tr>
                  @endif
            @endif 
          @endif

          @if($item->asistenciatrabajador->vid >= $fechainicio && $item->asistenciatrabajador->vid <= $fechafin)               
            @if($item->vih == 1)
                <tr>
                  <td>{{date_format(date_create($item->asistenciatrabajador->vid), 'd-m-Y')}}</td>
                  <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                  <td>{{$itemt->area->nombre}}</td>                    
                  <td>{{$item->asistenciatrabajador->vimi}}</td>
                  <td>{{$item->asistenciatrabajador->vimri}}</td>
                  <td>{{$item->asistenciatrabajador->vimrf}}</td>
                  <td>{{$item->asistenciatrabajador->vimf}}</td>

                  @php
                    $key              =   array_search($item->asistenciatrabajador->hvi, array_column($horario, 'id'));
                    $horainicio       =   $horario[$key]['horainicio'];
                    $horafin          =   $horario[$key]['horafin'];
                    $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                    $minutos          =   0;
                  @endphp
                  @if($item->asistenciatrabajador->vimi <> '' && $item->asistenciatrabajador->vimi < $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($item->asistenciatrabajador->vimi,$horainicio) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @if($item->asistenciatrabajador->vimf <> '' && $item->asistenciatrabajador->vimf > $horafin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horafin,$item->asistenciatrabajador->vimf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $sobretiempo  =   $sobretiempo + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>

                  @php $minutos =   0; @endphp
                  @if($item->asistenciatrabajador->vimi <> '' && $item->asistenciatrabajador->vimi > $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horainicio ,$item->asistenciatrabajador->vimi) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @if($item->asistenciatrabajador->vimrf <> '' && $item->asistenciatrabajador->vimrf > $refrigeriofin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($refrigeriofin,$item->asistenciatrabajador->vimrf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $tardanza  =   $tardanza + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>
                  <td>x</td>
                  <td>x</td>                               
                </tr> 
            @else
                @php
                    $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->vid);
                @endphp
                  @if ($vacadesc <> '')
                    <tr>
                      <td>{{date_format(date_create($item->asistenciatrabajador->vid), 'd-m-Y')}}</td>
                      <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                      <td>{{$itemt->area->nombre}}</td>                     
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                    </tr>
                  @endif
            @endif
          @endif

          @if($item->asistenciatrabajador->sad >= $fechainicio && $item->asistenciatrabajador->sad <= $fechafin)
            @if($item->sah == 1)
                <tr>
                  <td>{{date_format(date_create($item->asistenciatrabajador->sad), 'd-m-Y')}}</td>
                  <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                  <td>{{$itemt->area->nombre}}</td>                    
                  <td>{{$item->asistenciatrabajador->sami}}</td>
                  <td>{{$item->asistenciatrabajador->samri}}</td>
                  <td>{{$item->asistenciatrabajador->samrf}}</td>
                  <td>{{$item->asistenciatrabajador->samf}}</td>

                  @php
                    $key              =   array_search($item->asistenciatrabajador->hsa, array_column($horario, 'id'));
                    $horainicio       =   $horario[$key]['horainicio'];
                    $horafin          =   $horario[$key]['horafin'];
                    $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                    $minutos          =   0;
                  @endphp
                  @if($item->asistenciatrabajador->sami <> '' && $item->asistenciatrabajador->sami < $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($item->asistenciatrabajador->sami,$horainicio) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @if($item->asistenciatrabajador->samf <> '' && $item->asistenciatrabajador->samf > $horafin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horafin,$item->asistenciatrabajador->samf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @php $sobretiempo  =   $sobretiempo + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>


                  @php $minutos =   0; @endphp
                  @if($item->asistenciatrabajador->sami <> '' && $item->asistenciatrabajador->sami > $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horainicio ,$item->asistenciatrabajador->sami) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @if($item->asistenciatrabajador->samrf <> '' && $item->asistenciatrabajador->samrf > $refrigeriofin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($refrigeriofin,$item->asistenciatrabajador->samrf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $tardanza  =   $tardanza + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>

                  <td>x</td>
                  <td>x</td>                               
                </tr> 
            @else
                @php
                    $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->sad);
                @endphp
                  @if ($vacadesc <> '')
                    <tr>
                      <td>{{date_format(date_create($item->asistenciatrabajador->sad), 'd-m-Y')}}</td>
                      <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                      <td>{{$itemt->area->nombre}}</td>                    
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                      <td class='reportevacadesc' >{{$vacadesc}}</td>
                    </tr>
                  @endif
            @endif
          @endif

          @if($item->asistenciatrabajador->dod >= $fechainicio && $item->asistenciatrabajador->dod <= $fechafin)            
            @if($item->doh == 1)
                <tr>
                  <td>{{date_format(date_create($item->asistenciatrabajador->dod), 'd-m-Y')}}</td>
                  <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                  <td>{{$itemt->area->nombre}}</td>                    
                  <td>{{$item->asistenciatrabajador->domi}}</td>
                  <td>{{$item->asistenciatrabajador->domri}}</td>
                  <td>{{$item->asistenciatrabajador->domrf}}</td>
                  <td>{{$item->asistenciatrabajador->domf}}</td>

                  @php
                    $key              =   array_search($item->asistenciatrabajador->hdo, array_column($horario, 'id'));
                    $horainicio       =   $horario[$key]['horainicio'];
                    $horafin          =   $horario[$key]['horafin'];
                    $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                    $minutos          =   0;
                  @endphp
                  @if($item->asistenciatrabajador->domi <> '' && $item->asistenciatrabajador->domi < $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($item->asistenciatrabajador->domi,$horainicio) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @if($item->asistenciatrabajador->domf <> '' && $item->asistenciatrabajador->domf > $horafin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horafin,$item->asistenciatrabajador->domf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif
                  @php $sobretiempo  =   $sobretiempo + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>


                  @php $minutos =   0; @endphp
                  @if($item->asistenciatrabajador->domi <> '' && $item->asistenciatrabajador->domi > $horainicio)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($horainicio ,$item->asistenciatrabajador->domi) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @if($item->asistenciatrabajador->domrf <> '' && $item->asistenciatrabajador->domrf > $refrigeriofin)
                    @php  $minutos =  $minutos + $funcion->funciones->minutosdoshoras($refrigeriofin,$item->asistenciatrabajador->domrf) @endphp 
                  @else
                    @php  $minutos =  $minutos +  0; @endphp                
                  @endif

                  @php $tardanza  =   $tardanza + $minutos;  @endphp
                  <td>{{$funcion->funciones->formatohorasminutos($minutos)}}</td>

                  
                  <td>x</td>
                  <td>x</td>                               
                </tr> 
            @else
                @php
                    $vacadesc         =   $funcion->funciones->stringvacacionesdescanso($item->id,$item->dod);
                @endphp
                  @if ($vacadesc <> '')
                    <tr>
                      <td>{{date_format(date_create($item->asistenciatrabajador->dod), 'd-m-Y')}}</td>
                      <td>{{$itemt->apellidopaterno}}  {{$itemt->apellidomaterno}} {{$itemt->nombres}}</td>
                      <td>{{$itemt->area->nombre}}</td>                     
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                      <td class='reportevacadesc'>{{$vacadesc}}</td>
                    </tr>
                  @endif
            @endif     
          @endif

        @endforeach
      @endforeach
    </tbody>

    <tfooter>


      <tr>
        <th colspan = '7'>TOTALES</th>

        <th>{{$funcion->funciones->formatohorasminutos($sobretiempo)}}</th>
        <th>{{$funcion->funciones->formatohorasminutos($tardanza)}}</th>
        <th>x</th>
        <th>x</th> 

      </tr>
    </tfooter>

  </table>

</div>




<script type="text/javascript">
  $(document).ready(function(){
     App.dataTables();
  });
</script> 