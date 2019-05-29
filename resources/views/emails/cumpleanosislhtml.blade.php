<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />

        <style>

            .banner{
                margin: 0 auto;
                text-align: center;
                width: 700px;               
            }
            p{
                margin-bottom: 0px;
                margin-top: 0px;
                font-style: italic;
                text-align: center;
            }
            .titulo{
                margin-bottom: 3px;
                margin-top: 3px;
                font-weight: bold;
            }
            .jefatura{
                margin-bottom: 6px;
                margin-top: 3px;               
            }
        </style>


    </head>


    <body>
        <section>
            <div class='banner'>
                <table  bgcolor="#f6f6f6" >
                    <tr>
                        <td width='700' colspan="2">
                            <img src="http://alfasweb.com/img/cumpleanos/bannerisl.png" alt="Banner" />
                        </td>
                    </tr>

                    <tr>

        
                    @if(@GetImageSize('http://alfasweb.com/img/cumpleanos/41277715.png'))
                        <td width='500'>
                            <img src="http://alfasweb.com/img/cumpleanos/felizcumpleanossm.png" alt="Banner" />
                        </td>
                         <td width='200' rowspan="2">
                            <img src="http://alfasweb.com/img/cumpleanos/41277717.png" alt="Banner" />
                        </td>
                    @else
                        <td width='700' colspan="2">
                            <img src="http://alfasweb.com/img/cumpleanos/felizcentrado.png" alt="Banner" />
                        </td>                
                    @endif


                    </tr>
                    <tr>

                    @if(@GetImageSize('http://alfasweb.com/img/cumpleanos/41277715.png'))
                        <td width='500'>
                                <p class='nombre'>Querido(a):</p>
                                <p class='titulo'>JENNY RODAS CHILCÓN</p>
                                <p class='jefatura'>Jefe de Recursos Humanos</p>  
                                <p class='agradecimiento'>
                                    Que tus regalos hoy sean amor y felicidad, <br>
                                    sobre todo la bendicion de DIOS,  que tu día<br>
                                    este lleno de dulces sorpresas.</p>                                                         
                        </td>
                    @else
                        <td width='700' colspan="2">
                                <p class='nombre'>Querido(a):</p>
                                <p class='titulo'>JENNY RODAS CHILCÓN</p>
                                <p class='jefatura'>Jefe de Recursos Humanos</p>  
                                <p class='agradecimiento'>
                                    Que tus regalos hoy sean amor y felicidad, <br>
                                    sobre todo la bendicion de DIOS,  que tu día<br>
                                    este lleno de dulces sorpresas.</p> 
                        </td>                
                    @endif


                    </tr>
                    <tr>
                        <td width='700' colspan="2"><img src="http://alfasweb.com/img/cumpleanos/familia.png" alt="Banner" /></td>
                    </tr>


                </table>
            </div>            
        </section>
    </body>

</html>


