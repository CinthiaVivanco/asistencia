<div class='row reporte'>

  <table id="" class="table table-striped table-hover table-fw-widget">
    <thead>
      <tr>
        <th class= 'tabladp'>PERIODO</th>
        <th class= 'tabladp'>FECHA DEL PERIODO</th>
        <th class= 'tabladp'>FECHA</th>
        <th class= 'tabladp'>TIPO DE DIA</th>
      </tr>
    </thead>

    <tbody>
      @foreach($listadias as $item) 
            <tr>
                <td class='negrita'>{{$item->periodo->descripcion}}</td>
                <td class='negrita'>{{date("d/m/Y", strtotime($item->semana->fechainicio))}} Hasta {{date("d/m/Y", strtotime($item->semana->fechafin))}}</td>
                <td class='negrita'>{{date("d/m/Y", strtotime($item->fecha))}}</td>
                @if($item->tipodia->descripcion == 'DOMINGO')
                  <td class='domingo'>{{$item->tipodia->descripcion}}</td>
                @endif
                @if($item->tipodia->descripcion == 'Laborable')
                  <td class='negrita'>{{$item->tipodia->descripcion}}</td>
                @endif
                @if($item->tipodia->descripcion == 'FERIADO')
                  <td class='feriado'>{{$item->tipodia->descripcion}}</td>
                @endif
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