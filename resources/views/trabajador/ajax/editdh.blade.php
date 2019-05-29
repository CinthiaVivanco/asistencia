<form method="POST" action="{{ url('/modificar-derecho-habiente-trabajador/'.$id.'/'.$idopcion.'/'.$idtrabajador) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed"> 
    {{ csrf_field() }}
  	@include('trabajador.form.derechohabiente')
</form>
