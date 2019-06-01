

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
        <td class='datostrabajador @if($item->activo == 0) trabajadorbaja @endif'>  
            {{$item->trabajador->apellidopaterno}} {{$item->trabajador->apellidomaterno}} {{$item->trabajador->nombres}}<br>
            <small>{{$item->trabajador->area->nombre}} </small><br>
            <small>{{$item->trabajador->local->empresa->descripcion}}</small>

          <div class="buttons btnbaja">
            <button id ='bajatrabajadorhorario' 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-estado = '{{$item->activo}}'
                    class='@if($item->activo == 0) seleccion @endif'
              >B</button>
          </div>

        </td>
        <td class="cell-detail @if($item->activo == 0) ocultarbaja @endif">

          <div class="text-center be-checkbox be-checkbox-sm">

            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -12))}}"
                    id="lu{{Hashids::encode(substr($item->id, -12))}}"
                    @if ($item->luh == 1) checked @endif >
            <label  for="lu{{Hashids::encode(substr($item->id, -12))}}"
                    data-atr = "luh"
                    data-dia = "lu"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -12))}}"
              ></label>
          </div>

          {!! 
            Form::select( 'horario_id', 
                          $combohorariom, 
                          $item->hlu,
                          [
                            'class'       => 'comboh form-control control input-fr' ,
                            'id'          => 'horario_id',
                            'required'    => '',
                            'data-aw'     => '1',
                            'data-attr'   => 'lu',
                            'data-id'     => Hashids::encode(substr($item->id, -12))
                          ]) 
          !!}

          <span class="text-center cell-detail-description cell-detail-descriptionfr">
            {{date_format(date_create($item->lud), 'd/m/Y')}}
            {{substr($item->lud, 5, 1)}}
          </span>
          <span class="text-center cell-detail-description cell-detail-descriptionfr labelhora">
            {{$item->rhlu}}
          </span>

          <div class="buttons" data-estado_btn = '{{$funcion->funciones->activovacadesc($item->lud,$item->id)}}'>
            <button id ='vacaciones' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->lud,$item->id,'v')}}" 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'lu'
                    data-estado = 'v'
                    data-horario = "{{$item->lud}}"
                    data-activo-btn = '{{$funcion->funciones->activovaca($item->lud,$item->id)}}'
              >V</button>
            <button id ='descanso' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->lud,$item->id,'d')}}"  
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'lu'
                    data-estado = 'd'
                    data-horario = "{{$item->lud}}"
                    data-activo-btn = '{{$funcion->funciones->activodesc($item->lud,$item->id)}}'
              >D</button>
          </div>


        </td>
        <td class="cell-detail @if($item->activo == 0) ocultarbaja @endif">

          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -12))}}"
                    id="ma{{Hashids::encode(substr($item->id, -12))}}"
                    @if ($item->mah == 1) checked @endif >
            <label  for="ma{{Hashids::encode(substr($item->id, -12))}}"
                    data-atr = "mah"
                    data-dia = "ma"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -12))}}"
              ></label>
          </div>



          {!! 
            Form::select( 'horario_id', 
                          $combohorariom, 
                          $item->hma,
                          [
                            'class'       => 'comboh form-control control input-fr' ,
                            'id'          => 'horario_id',
                            'required'    => '',
                            'data-attr'   => 'ma',
                            'data-aw'     => '1',
                            'data-id'     => Hashids::encode(substr($item->id, -12))
                          ]) 
          !!}

          <span class="text-center cell-detail-description cell-detail-descriptionfr">
            {{date_format(date_create($item->mad), 'd/m/Y')}}
          </span>
          <span class="text-center cell-detail-description cell-detail-descriptionfr labelhora">
            {{$item->rhma}}
          </span>   

          <div class="buttons" data-estado_btn = '{{$funcion->funciones->activovacadesc($item->mad,$item->id)}}'>
            <button id ='vacaciones' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->mad,$item->id,'v')}}" 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'ma'
                    data-estado = 'v'
                    data-horario = "{{$item->mad}}"
                    data-activo-btn = '{{$funcion->funciones->activovaca($item->mad,$item->id)}}'
              >V</button>
            <button id ='descanso' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->mad,$item->id,'d')}}"  
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'ma'
                    data-estado = 'd'
                    data-horario = "{{$item->mad}}"
                    data-activo-btn = '{{$funcion->funciones->activodesc($item->mad,$item->id)}}'
              >D</button>
          </div>

        </td>
        <td class="cell-detail @if($item->activo == 0) ocultarbaja @endif">

          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -12))}}"
                    id="mi{{Hashids::encode(substr($item->id, -12))}}"
                    @if ($item->mih == 1) checked @endif >
            <label  for="mi{{Hashids::encode(substr($item->id, -12))}}"
                    data-atr = "mih"
                    data-dia = "mi"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -12))}}"
              ></label>
          </div>

          {!! 
            Form::select( 'horario_id', 
                          $combohorariom, 
                          $item->hmi,
                          [
                            'class'       => 'comboh form-control control input-fr' ,
                            'id'          => 'horario_id',
                            'required'    => '',
                            'data-attr'   => 'mi',
                            'data-aw'     => '1',
                            'data-id'     => Hashids::encode(substr($item->id, -12))
                          ]) 
          !!}

          <span class="text-center cell-detail-description cell-detail-descriptionfr">
            {{date_format(date_create($item->mid), 'd/m/Y')}}
          </span>
          <span class="text-center cell-detail-description cell-detail-descriptionfr labelhora">
            {{$item->rhmi}}
          </span> 

          <div class="buttons" data-estado_btn = '{{$funcion->funciones->activovacadesc($item->mid,$item->id)}}'>
            <button id ='vacaciones' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->mid,$item->id,'v')}}" 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'mi'
                    data-estado = 'v'
                    data-horario = "{{$item->mid}}"
                    data-activo-btn = '{{$funcion->funciones->activovaca($item->mid,$item->id)}}'
              >V</button>
            <button id ='descanso' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->mid,$item->id,'d')}}"  
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'mi'
                    data-estado = 'd'
                    data-horario = "{{$item->mid}}"
                    data-activo-btn = '{{$funcion->funciones->activodesc($item->mid,$item->id)}}'
              >D</button>
          </div>


        </td>
        <td class="cell-detail @if($item->activo == 0) ocultarbaja @endif">

          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -12))}}"
                    id="ju{{Hashids::encode(substr($item->id, -12))}}"
                    @if ($item->juh == 1) checked @endif >
            <label  for="ju{{Hashids::encode(substr($item->id, -12))}}"
                    data-atr = "juh"
                    data-dia = "ju"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -12))}}"
              ></label>
          </div>

          {!! 
            Form::select( 'horario_id', 
                          $combohorariom, 
                          $item->hju,
                          [
                            'class'       => 'comboh form-control control input-fr' ,
                            'id'          => 'horario_id',
                            'required'    => '',
                            'data-attr'   => 'ju',
                            'data-aw'     => '1',
                            'data-id'     => Hashids::encode(substr($item->id, -12))
                          ]) 
          !!}

          <span class="text-center cell-detail-description cell-detail-descriptionfr">
            {{date_format(date_create($item->jud), 'd/m/Y')}}
          </span>
          <span class="text-center cell-detail-description cell-detail-descriptionfr labelhora">
            {{$item->rhju}}
          </span>

          <div class="buttons" data-estado_btn = '{{$funcion->funciones->activovacadesc($item->jud,$item->id)}}'>
            <button id ='vacaciones' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->jud,$item->id,'v')}}" 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'ju'
                    data-estado = 'v'
                    data-horario = "{{$item->jud}}"
                    data-activo-btn = '{{$funcion->funciones->activovaca($item->jud,$item->id)}}'
              >V</button>
            <button id ='descanso' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->jud,$item->id,'d')}}"  
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'ju'
                    data-estado = 'd'
                    data-horario = "{{$item->jud}}"
                    data-activo-btn = '{{$funcion->funciones->activodesc($item->jud,$item->id)}}'
              >D</button>
          </div>

        </td>
        <td class="cell-detail @if($item->activo == 0) ocultarbaja @endif">

          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -12))}}"
                    id="vi{{Hashids::encode(substr($item->id, -12))}}"
                    @if ($item->vih == 1) checked @endif >
            <label  for="vi{{Hashids::encode(substr($item->id, -12))}}"
                    data-atr = "vih"
                    data-dia = "vi"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -12))}}"
              ></label>
          </div>

          {!! 
            Form::select( 'horario_id', 
                          $combohorariom, 
                          $item->hvi,
                          [
                            'class'       => 'comboh form-control control input-fr' ,
                            'id'          => 'horario_id',
                            'required'    => '',
                            'data-attr'   => 'vi',
                            'data-aw'     => '1',
                            'data-id'     => Hashids::encode(substr($item->id, -12))
                          ]) 
          !!}

          <span class="text-center cell-detail-description cell-detail-descriptionfr">
            {{date_format(date_create($item->vid), 'd/m/Y')}}
          </span>
          <span class="text-center cell-detail-description cell-detail-descriptionfr labelhora">
            {{$item->rhvi}}
          </span> 

          <div class="buttons" data-estado_btn = '{{$funcion->funciones->activovacadesc($item->vid,$item->id)}}'>
            <button id ='vacaciones' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->vid,$item->id,'v')}}" 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'vi'
                    data-estado = 'v'
                    data-horario = "{{$item->vid}}"
                    data-activo-btn = '{{$funcion->funciones->activovaca($item->vid,$item->id)}}'
              >V</button>
            <button id ='descanso' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->vid,$item->id,'d')}}"  
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'vi'
                    data-estado = 'd'
                    data-horario = "{{$item->vid}}"
                    data-activo-btn = '{{$funcion->funciones->activodesc($item->vid,$item->id)}}'
              >D</button>
          </div>

        </td>
        <td class="cell-detail @if($item->activo == 0) ocultarbaja @endif">

          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -12))}}"
                    id="sa{{Hashids::encode(substr($item->id, -12))}}"
                    @if ($item->sah == 1) checked @endif >
            <label  for="sa{{Hashids::encode(substr($item->id, -12))}}"
                    data-atr = "sah"
                    data-dia = "sa"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -12))}}"
              ></label>
          </div>

          {!! 
            Form::select( 'horario_id', 
                          $combohorariom, 
                          $item->hsa,
                          [
                            'class'       => 'comboh form-control control input-fr' ,
                            'id'          => 'horario_id',
                            'required'    => '',
                            'data-attr'   => 'sa',
                            'data-aw'     => '1',
                            'data-id'     => Hashids::encode(substr($item->id, -12))
                          ]) 
          !!}

          <span class="text-center cell-detail-description cell-detail-descriptionfr">
            {{date_format(date_create($item->sad), 'd/m/Y')}}
          </span>
          <span class="text-center cell-detail-description cell-detail-descriptionfr labelhora">
            {{$item->rhsa}}
          </span>

          <div class="buttons" data-estado_btn = '{{$funcion->funciones->activovacadesc($item->sad,$item->id)}}'>
            <button id ='vacaciones' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->sad,$item->id,'v')}}" 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'sa'
                    data-estado = 'v'
                    data-horario = "{{$item->sad}}"
                    data-activo-btn = '{{$funcion->funciones->activovaca($item->sad,$item->id)}}'
              >V</button>
            <button id ='descanso' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->sad,$item->id,'d')}}"  
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'sa'
                    data-estado = 'd'
                    data-horario = "{{$item->sad}}"
                    data-activo-btn = '{{$funcion->funciones->activodesc($item->sad,$item->id)}}'
              >D</button>
          </div>

        </td>
        <td class="cell-detail @if($item->activo == 0) ocultarbaja @endif">

          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -12))}}"
                    id="do{{Hashids::encode(substr($item->id, -12))}}"
                    @if ($item->doh == 1) checked @endif >
            <label  for="do{{Hashids::encode(substr($item->id, -12))}}"
                    data-atr = "doh"
                    data-dia = "do"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -12))}}"
              ></label>
          </div>

          {!! 
            Form::select( 'horario_id', 
                          $combohorariom, 
                          $item->hdo,
                          [
                            'class'       => 'comboh form-control control input-fr' ,
                            'id'          => 'horario_id',
                            'required'    => '',
                            'data-attr'   => 'do',
                            'data-aw'     => '1',
                            'data-id'     => Hashids::encode(substr($item->id, -12))
                          ]) 
          !!}

          <span class="text-center cell-detail-description cell-detail-descriptionfr">
            {{date_format(date_create($item->dod), 'd/m/Y')}}
          </span>
          <span class="text-center cell-detail-description cell-detail-descriptionfr labelhora">
            {{$item->rhdo}}
          </span> 

          <div class="buttons" data-estado_btn = '{{$funcion->funciones->activovacadesc($item->dod,$item->id)}}'>
            <button id ='vacaciones' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->dod,$item->id,'v')}}" 
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'do'
                    data-estado = 'v'
                    data-horario = "{{$item->dod}}"
                    data-activo-btn = '{{$funcion->funciones->activovaca($item->dod,$item->id)}}'
              >V</button>
            <button id ='descanso' 
                    class="vacadesc {{$funcion->funciones->seleccionvacadesc($item->dod,$item->id,'d')}}"  
                    data-id = '{{Hashids::encode(substr($item->id, -12))}}'
                    data-attr   = 'do'
                    data-estado = 'd'
                    data-horario = "{{$item->dod}}"
                    data-activo-btn = '{{$funcion->funciones->activodesc($item->dod,$item->id)}}'
              >D</button>
          </div>

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