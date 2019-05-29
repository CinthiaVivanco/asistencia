<div id='{{$dia}}{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}'>

  <span class="cell-detail-description  
               cell-detail-fecha">
            {{date_format(date_create($asistenciatrabajador->$diad), 'd-m-Y')}}
  </span>
  
  <span class="cell-detail-description 
               cell-detail-descriptionfr 
               cell-detail-time 
               {{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,1)}}">
    ENTRADA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'horainicio')}})
  </span>
  <span class="cell-detail-description cell-detail-hora">
    {{$asistenciatrabajador->$diami}}
  </span>
  @if ($asistenciatrabajador->$diacantmarc == 4) 

    <span class="cell-detail-description 
                 cell-detail-descriptionfr 
                 cell-detail-time 
                 {{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,2)}}">
       REF. SALIDA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'refrigerioinicio')}})
    </span>
    <span class="cell-detail-description cell-detail-hora">
      {{$asistenciatrabajador->$diamri}}
    </span>          
    <span class="cell-detail-description 
                 cell-detail-descriptionfr 
                 cell-detail-time 
                 {{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,3)}}">
       REF. ENTRADA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'refrigeriofin')}})
    </span>
    <span class="cell-detail-description cell-detail-hora">
      {{$asistenciatrabajador->$diamrf}}
    </span> 

  @endif 

  <span class="cell-detail-description 
               cell-detail-descriptionfr 
               cell-detail-time 
               {{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,$asistenciatrabajador->$diacantmarc)}}">
     SALIDA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'horafin')}})
  </span>
  <span class="cell-detail-description cell-detail-hora">
    {{$asistenciatrabajador->$diamf}}
  </span> 

  <button type="button" class="btn btn-success"
      id          = "btnhoraasitencia"
      data-id     = "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
      data-ajax   = "{{$dia}}{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
      data-tid    = "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
      data-fecha  = "{{$asistenciatrabajador->$diad}}"
      data-dia    = "{{$dia}}"
      data-toggle="modal" data-target="#mod-horaasistencia"
  >
    <span class="icon mdi mdi-edit"></span>
  </button>
</div>