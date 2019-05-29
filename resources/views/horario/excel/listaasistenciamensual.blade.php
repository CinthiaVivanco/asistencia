<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	{!! Html::style('public/css/excel/excel.css') !!}


    <!-- titulo -->
    <table>
        <tr>
            <td colspan="13"><h1>{{$titulo}}</h1></td>
        </tr>

        <tr>
            <td colspan="13"></td>
        </tr>

        <tr>
            <th colspan="5" class='titulotabla center tabladp'>DATOS PERSONALES</th>
            <th colspan="4" class='titulotabla center tablaho'>HORARIO</th>        
            <th colspan="4" class='titulotabla center tablaagrupado'>MARCACION</th>    
        </tr>

        <tr>
            <th width="10" class= 'tabladp'>Fecha</th>
            <th width="10" class= 'tabladp'>Dni</th>
            <th width="40" class= 'tabladp'>Apellidos y Nombres</th>
            <th width="20" class= 'tabladp'>Empresa</th>
            <th width="30" class= 'tabladp'>Area</th>            

            <th width="10" class= 'titulotabla tablaho'>Ent.</th>
            <th width="10" class= 'titulotabla tablaho'>Sal R.</th>
            <th width="10" class= 'titulotabla tablaho'>Ent R.</th> 
            <th width="10" class= 'titulotabla tablaho'>Sal.</th> 
            <th width="10" class= 'titulotabla tablaagrupado'>Ent.</th>
            <th width="10" class= 'titulotabla tablaagrupado'>Sal R.</th>
            <th width="10" class= 'titulotabla tablaagrupado'>Ent R.</th> 
            <th width="10" class= 'titulotabla tablaagrupado'>Sal.</th> 
                 
        </tr>

        @foreach($listaasistencia as $item) 
            @if($item->asistenciatrabajador->lud >= $fechainicio && $item->asistenciatrabajador->lud <= $fechafin)
              @if($item->luh == 1)
                  <tr>
                    <td>{{date_format(date_create($item->asistenciatrabajador->lud), 'd/m/Y')}}</td>
                    <td>{{$item->trabajador->dni}}</td>              
                    <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                    <td>{{$item->trabajador->area->nombre}}</td>

                    @php
                      $key              =   array_search($item->asistenciatrabajador->hlu, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $marcacion        =   $horario[$key]['marcacion'];
                    @endphp
                    
                    <td>{{$horainicio}}</td>
                    <td>{{$refrigerioinicio}}</td>
                    <td>{{$refrigeriofin}}</td> 
                    <td>{{$horafin}}</td>    

                    <td>
                      @if ($item->asistenciatrabajador->lumi <> '') 
                        @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->lumi) 
                            {{$horainicio}}
                        @else
                            {{$item->asistenciatrabajador->lumi}}
                        @endif 
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->lumri <> '')
                        @if ($marcacion>2)
                          @if ($item->asistenciatrabajador->lumri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                              {{$refrigerioinicio}}
                          @else
                              {{$item->asistenciatrabajador->lumri}}
                          @endif 
                        @else
                          {{$item->asistenciatrabajador->lumri}}
                        @endif                   
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->lumrf <> '') 
                        @if ($marcacion>2)
                          @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->lumrf) 
                              {{$refrigeriofin}}
                          @else
                              {{$item->asistenciatrabajador->lumrf}}
                          @endif                    
                        @else
                          {{$item->asistenciatrabajador->lumrf}}
                        @endif
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->lumf <> '')
                        @if ($item->asistenciatrabajador->lumf > $funcion->funciones->sumarminutos($horafin,15)) 
                            {{$horafin}}
                        @else
                            {{$item->asistenciatrabajador->lumf}}
                        @endif 
                      @endif
                    </td>  
                                     
                  </tr> 
              @else
                  @php
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->lud);
                  @endphp
                    @if ($vacadesc <> '')
                      <tr>
                        <td>{{date_format(date_create($item->asistenciatrabajador->lud), 'd/m/Y')}}</td>
                        <td>{{$item->trabajador->dni}}</td>              
                        <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                        <td>{{$item->trabajador->area->nombre}}</td>

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

            @if($item->asistenciatrabajador->mad >= $fechainicio && $item->asistenciatrabajador->mad <= $fechafin)
              @if($item->mah == 1)
                  <tr>
                    <td>{{date_format(date_create($item->asistenciatrabajador->mad), 'd/m/Y')}}</td>
                    <td>{{$item->trabajador->dni}}</td>              
                    <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                    <td>{{$item->trabajador->area->nombre}}</td>

                    @php
                      $key              =   array_search($item->asistenciatrabajador->hma, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $marcacion        =   $horario[$key]['marcacion'];                
                    @endphp
                    
                    <td>{{$horainicio}}</td>
                    <td>{{$refrigerioinicio}}</td>
                    <td>{{$refrigeriofin}}</td> 
                    <td>{{$horafin}}</td> 


                    <td>
                      @if ($item->asistenciatrabajador->mami <> '') 
                        @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->mami) 
                            {{$horainicio}}
                        @else
                            {{$item->asistenciatrabajador->mami}}
                        @endif 
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->mamri <> '')
                        @if ($marcacion>2)
                          @if ($item->asistenciatrabajador->mamri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                              {{$refrigerioinicio}}
                          @else
                              {{$item->asistenciatrabajador->mamri}}
                          @endif 
                        @else
                          {{$item->asistenciatrabajador->mamri}}
                        @endif                   
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->mamrf <> '') 
                        @if ($marcacion>2)
                          @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->mamrf) 
                              {{$refrigeriofin}}
                          @else
                              {{$item->asistenciatrabajador->mamrf}}
                          @endif                    
                        @else
                          {{$item->asistenciatrabajador->mamrf}}
                        @endif
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->mamf <> '')
                        @if ($item->asistenciatrabajador->mamf > $funcion->funciones->sumarminutos($horafin,15)) 
                            {{$horafin}}
                        @else
                            {{$item->asistenciatrabajador->mamf}}
                        @endif 
                      @endif
                    </td>  
                                   
                  </tr> 
              @else
                  @php
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->mad);
                  @endphp
                    @if ($vacadesc <> '')
                      <tr>
                        <td>{{date_format(date_create($item->asistenciatrabajador->mad), 'd/m/Y')}}</td>
                        <td>{{$item->trabajador->dni}}</td>              
                        <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                        <td>{{$item->trabajador->area->nombre}}</td>
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

            @if($item->asistenciatrabajador->mid >= $fechainicio && $item->asistenciatrabajador->mid <= $fechafin)
              @if($item->mih == 1)
                  <tr>
                    <td>{{date_format(date_create($item->asistenciatrabajador->mid), 'd/m/Y')}}</td>
                    <td>{{$item->trabajador->dni}}</td>              
                    <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                    <td>{{$item->trabajador->area->nombre}}</td>

                    @php
                      $key              =   array_search($item->asistenciatrabajador->hmi, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $marcacion        =   $horario[$key]['marcacion'];                
                    @endphp
                    
                    <td>{{$horainicio}}</td>
                    <td>{{$refrigerioinicio}}</td>
                    <td>{{$refrigeriofin}}</td> 
                    <td>{{$horafin}}</td> 

                    <td>
                      @if ($item->asistenciatrabajador->mimi <> '') 
                        @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->mimi) 
                            {{$horainicio}}
                        @else
                            {{$item->asistenciatrabajador->mimi}}
                        @endif 
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->mimri <> '')
                        @if ($marcacion>2)
                          @if ($item->asistenciatrabajador->mimri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                              {{$refrigerioinicio}}
                          @else
                              {{$item->asistenciatrabajador->mimri}}
                          @endif 
                        @else
                          {{$item->asistenciatrabajador->mimri}}
                        @endif                   
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->mimrf <> '') 
                        @if ($marcacion>2)
                          @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->mimrf) 
                              {{$refrigeriofin}}
                          @else
                              {{$item->asistenciatrabajador->mimrf}}
                          @endif                    
                        @else
                          {{$item->asistenciatrabajador->mimrf}}
                        @endif
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->mimf <> '')
                        @if ($item->asistenciatrabajador->mimf > $funcion->funciones->sumarminutos($horafin,15)) 
                            {{$horafin}}
                        @else
                            {{$item->asistenciatrabajador->mimf}}
                        @endif 
                      @endif
                    </td>  
                                   
                  </tr> 
              @else
                  @php
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->mid);
                  @endphp
                    @if ($vacadesc <> '')
                      <tr>
                        <td>{{date_format(date_create($item->asistenciatrabajador->mid), 'd/m/Y')}}</td>
                        <td>{{$item->trabajador->dni}}</td>              
                        <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                        <td>{{$item->trabajador->area->nombre}}</td>
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

            @if($item->asistenciatrabajador->jud >= $fechainicio && $item->asistenciatrabajador->jud <= $fechafin)
              @if($item->juh == 1)
                  <tr>
                    <td>{{date_format(date_create($item->asistenciatrabajador->jud), 'd/m/Y')}}</td>
                    <td>{{$item->trabajador->dni}}</td>              
                    <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                    <td>{{$item->trabajador->area->nombre}}</td>

                    @php
                      $key              =   array_search($item->asistenciatrabajador->hju, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $marcacion        =   $horario[$key]['marcacion'];                
                    @endphp
                    
                    <td>{{$horainicio}}</td>
                    <td>{{$refrigerioinicio}}</td>
                    <td>{{$refrigeriofin}}</td> 
                    <td>{{$horafin}}</td> 

                    <td>
                      @if ($item->asistenciatrabajador->jumi <> '') 
                        @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->jumi) 
                            {{$horainicio}}
                        @else
                            {{$item->asistenciatrabajador->jumi}}
                        @endif 
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->jumri <> '')
                        @if ($marcacion>2)
                          @if ($item->asistenciatrabajador->jumri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                              {{$refrigerioinicio}}
                          @else
                              {{$item->asistenciatrabajador->jumri}}
                          @endif 
                        @else
                          {{$item->asistenciatrabajador->jumri}}
                        @endif                   
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->jumrf <> '') 
                        @if ($marcacion>2)
                          @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->jumrf) 
                              {{$refrigeriofin}}
                          @else
                              {{$item->asistenciatrabajador->jumrf}}
                          @endif                    
                        @else
                          {{$item->asistenciatrabajador->jumrf}}
                        @endif
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->jumf <> '')
                        @if ($item->asistenciatrabajador->jumf > $funcion->funciones->sumarminutos($horafin,15)) 
                            {{$horafin}}
                        @else
                            {{$item->asistenciatrabajador->jumf}}
                        @endif 
                      @endif
                    </td>  
                                   
                  </tr> 
              @else
                  @php
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->jud);
                  @endphp
                    @if ($vacadesc <> '')
                      <tr>
                        <td>{{date_format(date_create($item->asistenciatrabajador->jud), 'd/m/Y')}}</td>
                        <td>{{$item->trabajador->dni}}</td>              
                        <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                        <td>{{$item->trabajador->area->nombre}}</td>
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

            @if($item->asistenciatrabajador->vid >= $fechainicio && $item->asistenciatrabajador->vid <= $fechafin)
              @if($item->vih == 1)
                  <tr>
                    <td>{{date_format(date_create($item->asistenciatrabajador->vid), 'd/m/Y')}}</td>
                    <td>{{$item->trabajador->dni}}</td>              
                    <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                    <td>{{$item->trabajador->area->nombre}}</td>
                    @php
                      $key              =   array_search($item->asistenciatrabajador->hvi, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $marcacion        =   $horario[$key]['marcacion'];                
                    @endphp
                    
                    <td>{{$horainicio}}</td>
                    <td>{{$refrigerioinicio}}</td>
                    <td>{{$refrigeriofin}}</td> 
                    <td>{{$horafin}}</td> 

                    <td>
                      @if ($item->asistenciatrabajador->vimi <> '') 
                        @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->vimi) 
                            {{$horainicio}}
                        @else
                            {{$item->asistenciatrabajador->vimi}}
                        @endif 
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->vimri <> '')
                        @if ($marcacion>2)
                          @if ($item->asistenciatrabajador->vimri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                              {{$refrigerioinicio}}
                          @else
                              {{$item->asistenciatrabajador->vimri}}
                          @endif 
                        @else
                          {{$item->asistenciatrabajador->vimri}}
                        @endif                   
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->vimrf <> '') 
                        @if ($marcacion>2)
                          @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->vimrf) 
                              {{$refrigeriofin}}
                          @else
                              {{$item->asistenciatrabajador->vimrf}}
                          @endif                    
                        @else
                          {{$item->asistenciatrabajador->vimrf}}
                        @endif
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->vimf <> '')
                        @if ($item->asistenciatrabajador->vimf > $funcion->funciones->sumarminutos($horafin,15)) 
                            {{$horafin}}
                        @else
                            {{$item->asistenciatrabajador->vimf}}
                        @endif 
                      @endif
                    </td>                                
                  </tr> 
              @else
                  @php
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->vid);
                  @endphp
                    @if ($vacadesc <> '')
                      <tr>
                        <td>{{date_format(date_create($item->asistenciatrabajador->vid), 'd/m/Y')}}</td>
                        <td>{{$item->trabajador->dni}}</td>              
                        <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                        <td>{{$item->trabajador->area->nombre}}</td>
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

            @if($item->asistenciatrabajador->sad >= $fechainicio && $item->asistenciatrabajador->sad <= $fechafin)
              @if($item->sah == 1)
                  <tr>
                    <td>{{date_format(date_create($item->asistenciatrabajador->sad), 'd/m/Y')}}</td>
                    <td>{{$item->trabajador->dni}}</td>              
                    <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                    <td>{{$item->trabajador->area->nombre}}</td>

                    @php
                      $key              =   array_search($item->asistenciatrabajador->hsa, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $marcacion        =   $horario[$key]['marcacion'];                
                    @endphp
                    
                    <td>{{$horainicio}}</td>
                    <td>{{$refrigerioinicio}}</td>
                    <td>{{$refrigeriofin}}</td> 
                    <td>{{$horafin}}</td> 

                    <td>
                      @if ($item->asistenciatrabajador->sami <> '') 
                        @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->sami) 
                            {{$horainicio}}
                        @else
                            {{$item->asistenciatrabajador->sami}}
                        @endif 
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->samri <> '')
                        @if ($marcacion>2)
                          @if ($item->asistenciatrabajador->samri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                              {{$refrigerioinicio}}
                          @else
                              {{$item->asistenciatrabajador->samri}}
                          @endif 
                        @else
                          {{$item->asistenciatrabajador->samri}}
                        @endif                   
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->samrf <> '') 
                        @if ($marcacion>2)
                          @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->samrf) 
                              {{$refrigeriofin}}
                          @else
                              {{$item->asistenciatrabajador->samrf}}
                          @endif                    
                        @else
                          {{$item->asistenciatrabajador->samrf}}
                        @endif
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->samf <> '')
                        @if ($item->asistenciatrabajador->samf > $funcion->funciones->sumarminutos($horafin,15)) 
                            {{$horafin}}
                        @else
                            {{$item->asistenciatrabajador->samf}}
                        @endif 
                      @endif
                    </td>  
                                    
                  </tr> 
              @else
                  @php
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->sad);
                  @endphp
                    @if ($vacadesc <> '')
                      <tr>
                        <td>{{date_format(date_create($item->asistenciatrabajador->sad), 'd/m/Y')}}</td>
                        <td>{{$item->trabajador->dni}}</td>              
                        <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                        <td>{{$item->trabajador->area->nombre}}</td>
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

            @if($item->asistenciatrabajador->dod >= $fechainicio && $item->asistenciatrabajador->dod <= $fechafin)
              @if($item->doh == 1)
                  <tr>
                    <td>{{date_format(date_create($item->asistenciatrabajador->dod), 'd/m/Y')}}</td>
                    <td>{{$item->trabajador->dni}}</td>              
                    <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                    <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                    <td>{{$item->trabajador->area->nombre}}</td>

                    @php
                      $key              =   array_search($item->asistenciatrabajador->hdo, array_column($horario, 'id'));
                      $horainicio       =   $horario[$key]['horainicio'];
                      $horafin          =   $horario[$key]['horafin'];
                      $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
                      $refrigeriofin    =   $horario[$key]['refrigeriofin'];
                      $marcacion        =   $horario[$key]['marcacion'];                
                    @endphp
                    
                    <td>{{$horainicio}}</td>
                    <td>{{$refrigerioinicio}}</td>
                    <td>{{$refrigeriofin}}</td> 
                    <td>{{$horafin}}</td> 

                    <td>
                      @if ($item->asistenciatrabajador->domi <> '') 
                        @if ($funcion->funciones->restarminutos($horainicio,5) > $item->asistenciatrabajador->domi) 
                            {{$horainicio}}
                        @else
                            {{$item->asistenciatrabajador->domi}}
                        @endif 
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->domri <> '')
                        @if ($marcacion>2)
                          @if ($item->asistenciatrabajador->domri > $funcion->funciones->sumarminutos($refrigerioinicio,8)) 
                              {{$refrigerioinicio}}
                          @else
                              {{$item->asistenciatrabajador->domri}}
                          @endif 
                        @else
                          {{$item->asistenciatrabajador->domri}}
                        @endif                   
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->domrf <> '') 
                        @if ($marcacion>2)
                          @if ($funcion->funciones->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->domrf) 
                              {{$refrigeriofin}}
                          @else
                              {{$item->asistenciatrabajador->domrf}}
                          @endif                    
                        @else
                          {{$item->asistenciatrabajador->domrf}}
                        @endif
                      @endif
                    </td>
                    <td>
                      @if ($item->asistenciatrabajador->domf <> '')
                        @if ($item->asistenciatrabajador->domf > $funcion->funciones->sumarminutos($horafin,15)) 
                            {{$horafin}}
                        @else
                            {{$item->asistenciatrabajador->domf}}
                        @endif 
                      @endif
                    </td>                                
                  </tr> 
              @else
                  @php
                      $vacadesc         =   $funcion->funciones->stringvacacionesdescansoexcel($item->id,$item->dod);
                  @endphp
                    @if ($vacadesc <> '')
                      <tr>
                        <td>{{date_format(date_create($item->asistenciatrabajador->dod), 'd/m/Y')}}</td>
                        <td>{{$item->trabajador->dni}}</td>              
                        <td>{{$item->trabajador->apellidopaterno}}  {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}</td>
                        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
                        <td>{{$item->trabajador->area->nombre}}</td>
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




    </table>



</html>
