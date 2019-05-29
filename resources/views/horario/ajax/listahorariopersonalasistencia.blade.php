

<table id="thorario" class="table table-striped table-striped dt-responsive nowrap listatabla" style='width: 100%;'>

  <thead>
    <tr>
      <th>Local</th>      
      <th>Area</th>      
      <th>Trabajador</th>
      <th class='text-center'>Lunes</th>
      <th class='text-center'>Martes</th>
      <th class='text-center'>Miercoles</th>
      <th class='text-center'>Jueves</th>
      <th class='text-center'>Viernes</th>
      <th class='text-center'>Sabado</th>
      <th class='text-center'>Domingo</th>     
    </tr>
  </thead>
  <tbody>

    @foreach($listahorario as $item)

      @php
        $idhorarios     = array_column(json_decode($item->trabajador->local->empresa->horarioempresa),'horario_id');
        $combohorariom  = array_only($combohorario, $idhorarios);
      @endphp
      <tr>
        <td>{{$item->trabajador->local->empresa->descripcion}}</td>
        <td>{{$item->trabajador->area->nombre}}</td>
        <td>  
            {{$item->trabajador->nombres}} {{$item->trabajador->apellidopaterno}} {{$item->trabajador->apellidomaterno}} <br>
            <small>{{$item->trabajador->area->nombre}} </small><br>
            <small>{{$item->trabajador->local->empresa->descripcion}}</small>
        </td>
        <td class="cell-detail cell-timepicker">
          @if ($item->luh == 1) 
            <div class='contenedortd' id='lu{{Hashids::encode(substr($item->trabajador->id, -12))}}'>

              <span class="cell-detail-description  
                           cell-detail-fecha">
                        {{date_format(date_create($item->asistenciatrabajador->lud), 'd-m-Y')}}
              </span>

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'lu',1)}}">
                ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hlu,'horainicio')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->lumi}}
              </span>

              @if ($item->asistenciatrabajador->lucantmarc == 4) 

                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'lu',2)}}">
                   REF. SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hlu,'refrigerioinicio')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->lumri}}
                </span>          
                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'lu',3)}}">
                   REF. ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hlu,'refrigeriofin')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->lumrf}}
                </span> 

              @endif 

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'lu',$item->asistenciatrabajador->lucantmarc)}}">
                 SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hlu,'horafin')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->lumf}}
              </span> 

              <button type="button" class="btn btn-success"
                  id          = "btnhoraasitencia"
                  data-id     = "{{Hashids::encode(substr($item->asistenciatrabajador->id, -12))}}"
                  data-ajax   = "lu{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-tid    = "{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-fecha  = "{{$item->asistenciatrabajador->lud}}"
                  data-dia    = "lu"
                  data-toggle="modal" data-target="#mod-horaasistencia"
              >
                <span class="icon mdi mdi-edit"></span>
              </button>
            </div>
          @endif
        </td>
        <td class="cell-detail cell-timepicker"> 
          @if ($item->mah == 1) 
            <div class='contenedortd' id='ma{{Hashids::encode(substr($item->trabajador->id, -12))}}'>

              <span class="cell-detail-description  
                           cell-detail-fecha">
                        {{date_format(date_create($item->asistenciatrabajador->mad), 'd-m-Y')}}
              </span>

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ma',1)}}">
                ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hma,'horainicio')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->mami}}
              </span>

              @if ($item->asistenciatrabajador->macantmarc == 4) 

                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ma',2)}}">
                   REF. SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hma,'refrigerioinicio')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->mamri}}
                </span>          
                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ma',3)}}">
                   REF. ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hma,'refrigeriofin')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->mamrf}}
                </span> 

              @endif 

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ma',$item->asistenciatrabajador->macantmarc)}}">
                 SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hma,'horafin')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->mamf}}
              </span> 

              <button type="button" class="btn btn-success"
                  id          = "btnhoraasitencia"
                  data-id     = "{{Hashids::encode(substr($item->asistenciatrabajador->id, -12))}}"
                  data-ajax   = "ma{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-tid    = "{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-fecha  = "{{$item->asistenciatrabajador->mad}}"
                  data-dia    = "ma"
                  data-toggle="modal" data-target="#mod-horaasistencia"
              >
                <span class="icon mdi mdi-edit"></span>
              </button>
            </div> 
          @endif
        </td>                                 
        <td class="cell-detail cell-timepicker">
          @if ($item->mih == 1) 
            <div class='contenedortd' id='mi{{Hashids::encode(substr($item->trabajador->id, -12))}}'>

              <span class="cell-detail-description  
                           cell-detail-fecha">
                        {{date_format(date_create($item->asistenciatrabajador->mid), 'd-m-Y')}}
              </span>

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'mi',1)}}">
                ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hmi,'horainicio')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->mimi}}
              </span>

              @if ($item->asistenciatrabajador->micantmarc == 4) 

                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'mi',2)}}">
                   REF. SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hmi,'refrigerioinicio')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->mimri}}
                </span>          
                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'mi',3)}}">
                   REF. ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hmi,'refrigeriofin')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->mimrf}}
                </span> 

              @endif 

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'mi',$item->asistenciatrabajador->micantmarc)}}">
                 SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hmi,'horafin')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->mimf}}
              </span> 

              <button type="button" class="btn btn-success"
                  id          = "btnhoraasitencia"
                  data-id     = "{{Hashids::encode(substr($item->asistenciatrabajador->id, -12))}}"
                  data-ajax   = "mi{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-tid    = "{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-fecha  = "{{$item->asistenciatrabajador->mid}}"
                  data-dia    = "mi"
                  data-toggle="modal" data-target="#mod-horaasistencia"
              >
                <span class="icon mdi mdi-edit"></span>
              </button>
            </div>  
          @endif
        </td>
        <td class="cell-detail cell-timepicker">
          @if ($item->juh == 1) 
            <div class='contenedortd' id='ju{{Hashids::encode(substr($item->trabajador->id, -12))}}'>

              <span class="cell-detail-description  
                           cell-detail-fecha">
                        {{date_format(date_create($item->asistenciatrabajador->jud), 'd-m-Y')}}
              </span>

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ju',1)}}">
                ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hju,'horainicio')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->jumi}}
              </span>

              @if ($item->asistenciatrabajador->jucantmarc == 4) 

                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ju',2)}}">
                   REF. SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hju,'refrigerioinicio')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->jumri}}
                </span>          
                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ju',3)}}">
                   REF. ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hju,'refrigeriofin')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->jumrf}}
                </span> 

              @endif 

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'ju',$item->asistenciatrabajador->jucantmarc)}}">
                 SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hju,'horafin')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->jumf}}
              </span> 

              <button type="button" class="btn btn-success"
                  id          = "btnhoraasitencia"
                  data-id     = "{{Hashids::encode(substr($item->asistenciatrabajador->id, -12))}}"
                  data-ajax   = "ju{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-tid    = "{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-fecha  = "{{$item->asistenciatrabajador->jud}}"
                  data-dia    = "ju"
                  data-toggle="modal" data-target="#mod-horaasistencia"
              >
                <span class="icon mdi mdi-edit"></span>
              </button>
            </div> 
          @endif
        </td> 
        <td class="cell-detail cell-timepicker">
          @if ($item->vih == 1) 
            <div id='vi{{Hashids::encode(substr($item->trabajador->id, -12))}}'>

              <span class="cell-detail-description  
                           cell-detail-fecha">
                        {{date_format(date_create($item->asistenciatrabajador->vid), 'd-m-Y')}}
              </span>

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'vi',1)}}">
                ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hvi,'horainicio')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->vimi}}
              </span>

              @if ($item->asistenciatrabajador->vicantmarc == 4) 

                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'vi',2)}}">
                   REF. SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hvi,'refrigerioinicio')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->vimri}}
                </span>          
                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'vi',3)}}">
                   REF. ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hvi,'refrigeriofin')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->vimrf}}
                </span> 

              @endif 

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'vi',$item->asistenciatrabajador->vicantmarc)}}">
                 SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hvi,'horafin')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->vimf}}
              </span> 

              <button type="button" class="btn btn-success"
                  id          = "btnhoraasitencia"
                  data-id     = "{{Hashids::encode(substr($item->asistenciatrabajador->id, -12))}}"
                  data-ajax   = "vi{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-tid    = "{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-fecha  = "{{$item->asistenciatrabajador->vid}}"
                  data-dia    = "vi"
                  data-toggle="modal" data-target="#mod-horaasistencia"
              >
                <span class="icon mdi mdi-edit"></span>
              </button>
            </div>  
          @endif
        </td>
        <td class="cell-detail cell-timepicker">
          @if ($item->sah == 1) 
            <div class='contenedortd' id='sa{{Hashids::encode(substr($item->trabajador->id, -12))}}'>

              <span class="cell-detail-description  
                           cell-detail-fecha">
                        {{date_format(date_create($item->asistenciatrabajador->sad), 'd-m-Y')}}
              </span>

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'sa',1)}}">
                ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hsa,'horainicio')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->sami}}
              </span>

              @if ($item->asistenciatrabajador->sacantmarc == 4) 

                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'sa',2)}}">
                   REF. SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hsa,'refrigerioinicio')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->samri}}
                </span>          
                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'sa',3)}}">
                   REF. ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hsa,'refrigeriofin')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->samrf}}
                </span> 

              @endif 

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'sa',$item->asistenciatrabajador->sacantmarc)}}">
                 SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hsa,'horafin')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->samf}}
              </span> 

              <button type="button" class="btn btn-success"
                  id          = "btnhoraasitencia"
                  data-id     = "{{Hashids::encode(substr($item->asistenciatrabajador->id, -12))}}"
                  data-ajax   = "sa{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-tid    = "{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-fecha  = "{{$item->asistenciatrabajador->sad}}"
                  data-dia    = "sa"
                  data-toggle="modal" data-target="#mod-horaasistencia"
              >
                <span class="icon mdi mdi-edit"></span>
              </button>
            </div> 
          @endif
        </td>
        <td class="cell-detail cell-timepicker">
          @if ($item->doh == 1)
            <div class='contenedortd' id='do{{Hashids::encode(substr($item->trabajador->id, -12))}}'>

              <span class="cell-detail-description  
                           cell-detail-fecha">
                        {{date_format(date_create($item->asistenciatrabajador->dod), 'd-m-Y')}}
              </span>

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'do',1)}}">
                ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hdo,'horainicio')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->domi}}
              </span>

              @if ($item->asistenciatrabajador->docantmarc == 4) 

                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'do',2)}}">
                   REF. SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hdo,'refrigerioinicio')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->domri}}
                </span>          
                <span class="cell-detail-description 
                             cell-detail-descriptionfr 
                             cell-detail-time 
                             {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'do',3)}}">
                   REF. ENTRADA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hdo,'refrigeriofin')}})
                </span>
                <span class="cell-detail-description cell-detail-hora">
                  {{$item->asistenciatrabajador->domrf}}
                </span> 

              @endif 

              <span class="cell-detail-description 
                           cell-detail-descriptionfr 
                           cell-detail-time 
                           {{$funcion->funciones->getcolormarco($item->asistenciatrabajador->id,'do',$item->asistenciatrabajador->docantmarc)}}">
                 SALIDA ({{$funcion->funciones->gethorario($item->asistenciatrabajador->hdo,'horafin')}})
              </span>
              <span class="cell-detail-description cell-detail-hora">
                {{$item->asistenciatrabajador->domf}}
              </span> 

              <button type="button" class="btn btn-success"
                  id          = "btnhoraasitencia"
                  data-id     = "{{Hashids::encode(substr($item->asistenciatrabajador->id, -12))}}"
                  data-ajax   = "do{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-tid    = "{{Hashids::encode(substr($item->trabajador->id, -12))}}"
                  data-fecha  = "{{$item->asistenciatrabajador->dod}}"
                  data-dia    = "do"
                  data-toggle="modal" data-target="#mod-horaasistencia"
              >
                <span class="icon mdi mdi-edit"></span>
              </button>
            </div>
          @endif
        </td>

      </tr>                    
    @endforeach

  </tbody>
</table>

    <script type="text/javascript">
      $(document).ready(function(){
          App.dataTables();
      });
    </script> 




