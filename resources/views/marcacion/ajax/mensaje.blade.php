<div class="col-md-12">
	<div class="datos">
			@if(count($trabajador) > 0)
				<div class="col-md-7">

						@if($resultado['error'] == '0')
							<h3>
								{{$resultado['mensaje']}}
							</h3>
						@endif
						<h3>
							{{$trabajador->dni}}
						</h3>
						<h3>
							{{$trabajador->nombres}} {{$trabajador->apellidopaterno}} {{$trabajador->apellidomaterno}}
						</h3>
						@if($resultado['error'] == '1')
							<h3 class='herror'>
								{{$resultado['mensaje']}}
							</h3>
						@endif
						@if($resultado['tardanza'] == '1')
							<h3 class='herror'>
								{{$resultado['msjtardanza']}}
							</h3>
						@endif			

				</div>
				<div class="col-md-5">
					<img class='foto' src="{{asset('public/img/fotos/'.$dnifoto.'.jpg')}}" alt="Avatar">
				</div>
			@else
					<h3 class='herror'>
						Trabajador no existe
					</h3>
			@endif

	</div>
</div>
<div class="col-md-12">
	<div class="panel-body">
	  <table class="table">
	    <thead>
	      <tr>
	        <th>Estado</th>
	        <th>Nombre</th>
	      </tr>
	    </thead>
	    <tbody>
                              @foreach($asistenciadiaria as $item)
                              <tr class="@if($item->estadoaviso == 'Entrada' or $item->estadoaviso == 'Salida') success  @else primary @endif">
                                <td >{{$item->estadoaviso}}</td>
                                <td>{{$item->alias}}</td>
                              </tr>                              
                              @endforeach
	    </tbody>
	  </table>
	</div>
</div>


