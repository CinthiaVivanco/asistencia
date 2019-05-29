<!DOCTYPE html>

<html lang="es">

<head>
	<title>{{$titulo}}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}"> 
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/pdf.css') }} "/>


</head>

<body>
    <header>
    		
    </header>
    <section>
        <h2>Horarios de {{$empresa->descripcion}}</h2>

        <article>

          <table>
     
            @php
                $sw = 0
            @endphp

            @foreach($listahorario as $item)

                @if($sw == 0)  
                    <tr>                   
                @endif  
                    <td class='fila' >
                        <div class='horario'>
                            <h5 class='center'><strong>{{$item->horario->nombre}}</strong></h5>
                            <p class='center'>({{$item->empresa->descripcion}})</p><br>
                            <p class='center'><strong class='negro '>Horario</strong></p>
                            <p>
                                <strong class= 'negro'>Entrada: </strong> <small class='horainicio'>{{$item->horario->horainicio}}</small><br>
                                <strong class= 'negro'>Ref. Salida: </strong> <small class='horarefrigeriinicio'>{{$item->horario->refrigerioinicio}}</small><br>
                                <strong class= 'negro'>Ref. Entrada: </strong> <small class='horarefrigerifin'>{{$item->horario->refrigeriofin}}</small><br>
                                <strong class= 'negro'>Salida: </strong> <small class='horafin'>{{$item->horario->horafin}}</small>
                            </p>    
                            <br>                                                  
                            <p  class='estado center'>
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


                    </td>
                    @php
                        $sw = $sw + 1
                    @endphp

                @if($sw == 3)  
                    </tr>
                    @php
                        $sw = 0
                    @endphp                    
                @endif                   
                   
            @endforeach
                   
                </tr>


          </table>



        </article>

    </section>

</body>
</html>