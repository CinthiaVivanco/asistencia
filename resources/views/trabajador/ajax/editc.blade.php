<form method="POST" action="{{ url('/modificar-ficha-contrato-trabajador/'.$id.'/'.$idopcion.'/'.$idtrabajador) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed"> 
    {{ csrf_field() }}
  	@include('trabajador.form.contrato')
</form>

    <script type="text/javascript">
      $(document).ready(function(){  

        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
    });
    </script>
