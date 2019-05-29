
<div class='profilehorario'>

    @foreach($listahorario as $item)
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-radius: 16px;">
            <div class="well profiledet col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">

                    <h5 style="text-align:center;"><strong id="user-name">{{$item->horario->nombre}}</strong></h5>
                    <p style="text-align:center;font-size: smaller;" id="user-frid">({{$item->empresa->descripcion}})</p>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 divider text-center"></div>
                    <p style="text-align:center;font-size: smaller;"><strong>Horario</strong></p>
                    <p style="text-align:left;font-size: smaller;">
                        <strong>Entrada: </strong> <small class='horainicio'>{{$item->horario->horainicio}}</small><br>
                        <strong>Ref. Salida: </strong> <small class='horarefrigeriinicio'>{{$item->horario->refrigerioinicio}}</small><br>
                        <strong>Ref. Entrada: </strong> <small class='horarefrigerifin'>{{$item->horario->refrigeriofin}}</small><br>
                        <strong>Salida: </strong> <small class='horafin'>{{$item->horario->horafin}}</small>
                    </p>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 divider text-center"></div>
                    <br>
                    <p style="text-align:center;font-size: smaller;">
                              @if($item->activo == 1)  
                                <span class="tags activo" id="user-status">
                                    Activado
                                </span>
                              @else 
                                <span class="tags desactivo" id="user-status">
                                    Desactivado
                                </span> 
                              @endif
                    </p>
                </div>
              </div>
            </div>
        </div>
    </div>
    @endforeach  

</div>

