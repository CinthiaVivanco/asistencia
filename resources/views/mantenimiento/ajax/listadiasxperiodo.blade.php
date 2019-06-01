<div class='row reporte'>

  <table id="" class="table table-striped table-hover table-fw-widget">
    <thead>
      <tr>
        <th class= 'tabladp'>PERIODO</th>
        <th class= 'tabladp'>FECHA INICIO</th>
        <th class= 'tabladp'>FECHA FIN</th>
        <th class= 'tabladp'>FECHA</th>
        <th class= 'tabladp'>TIPO DE DIA</th>
      </tr>
    </thead>

    <tbody>
      @foreach($listadias as $item) 
            <tr>
                <td class='negrita'>{{$item->periodo->descripcion}}</td>
                <td class='negrita'>{{$item->semana->fechainicio}}</td>
                <td class='negrita'>{{$item->semana->fechafin}}</td>
                <td class='negrita'>{{$item->fecha}}</td>
                <td class='negrita'>{{$item->tipodia->descripcion}}</td>
            </tr>       
      @endforeach

    </tbody>
  </table>
</div>

<script type="text/javascript">
  $(document).ready(function(){
     App.dataTables();
  });
</script> 