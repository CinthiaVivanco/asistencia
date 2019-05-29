<form method="POST" action="{{ url('/modificar-ficha-socioeconomica-trabajador/'.$id.'/'.$idopcion.'/'.$idtrabajador) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed"> 
    {{ csrf_field() }}
  	@include('trabajador.form.fichasocioeconomica')
</form>
