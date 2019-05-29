
    @foreach($listahorario as $item)

      @php
        $idhorarios     = array_column(json_decode($item->trabajador->local->empresa->horarioempresa),'horario_id');
        $combohorariom  = array_only($combohorario, $idhorarios);
      @endphp
                  
    @endforeach
  </div>
</div>

<div class="form-group ">

  <label class="col-sm-12 control-label labelleft" >Horario :</label>
  <div class="col-sm-12 abajocaja" >
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
  </div>
</div>

