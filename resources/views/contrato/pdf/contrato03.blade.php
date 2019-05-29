<!DOCTYPE html>

<html lang="es">

<head>
    <title>{{$titulo}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pdf.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/personal/contrato.css') }} "/>
    <script src="{{ asset('public/js/personal/contrato.js') }}" type="text/javascript"></script>
</head>

<body>
    <header>
            
    </header>
    <section>

       <h3 align="center">CONTRATO INDIVIDUAL DE TRABAJO SUJETO A MODALIDAD POR INCREMENTO DE ACTIVIDAD</h3><br><br>

        <article class="contrato">


            Conste por el presente documento, el Contrato Individual de Trabajo, de Naturaleza Temporal por Incremento de Actividad, que celebran conforme al Art. 57º del TUO del D. Leg 728 aprobado por D.S. 003-97-TR Ley de Productividad y Competitividad Laboral, de una parte INDUAMERICA SERVICIOS LOGISTICOS SAC, con RUC Nº 20479729141, y domicilio en CARRETERA PANAMERICANA NORTE KM 775, a la que se le denominará EL EMPLEADOR, representada por el señor Sixto Perales Huancaruna, identificado con DNI Nº 16722570; y de otra parte <font style="text-transform: uppercase;"> <strong>{{$contrato->trabajador->apellidopaterno}} {{$contrato->trabajador->apellidomaterno}},  {{$contrato->trabajador->nombres}}, </strong> </font>, al que en lo sucesivo se le designará como EL TRABAJADOR, identificado con DNI Nº {{$contrato->trabajador->dni}}, estado civil {{$contrato->trabajador->estadocivil->nombre}}, de (EDAD)de edad, de sexo (SEXO), con domicilio en {{$contrato->trabajador->tipovia->tipo}} {{$contrato->trabajador->nombrevia}}  {{$contrato->trabajador->numerovia}}, {{$contrato->trabajador->nombrezona}}, DISTRITO {{$contrato->trabajador->distrito->nombre}}, PROVINCIA {{$contrato->trabajador->provincia->nombre}}, DEPARTAMENTO {{$contrato->trabajador->departamento->nombre}}, en los términos y condiciones siguientes: <br><br>

            <strong>Primero.-</strong> La Empresa tiene como actividad principal el Servicios De Transporte De Carga Por Carretera (CIIU 6023). Producto de los recientes arrendamientos financieros celebrados con diversas instituciones financieras, la Empresa tiene la necesidad de contar con personal para cubrir las necesidades de recursos humanos originados por la implementación de un Sistema Informático de Información Gerencial. <br><br>

            Debido al incremento de Operaciones tiene la necesidad de contratar al nuevo personal.<br><br>

            <strong>Segundo.-</strong> La Empresa requiere cubrir de manera temporal las necesidades de recursos humanos, de acuerdo a las causas objetivas señaladas en la cláusula anterior.<br><br>

            <strong>Tercero.-</strong>Por el presente documento <strong>EL EMPLEADOR</strong> contrata de manera temporal bajo la modalidad  de incremento de actividad, los servicios de <strong>EL TRABAJADOR</strong> quien desempeñara el cargo de {{$contrato->cargo->nombre}}.<br><br>

            <strong>Cuarto.- </strong>El plazo de duración del presente contrato es de SEIS (06) MESES y rige desde el {{$contrato->fechainicio}}, fecha en que deberá empezar sus labores <strong>EL TRABAJADOR</strong> hasta el {{$contrato->fechafin}}, fecha en que termina su contrato.<br><br>

            <strong>Quinto.- </strong> El Trabajador observará el horario de trabajo siguiente: De Lunes a Viernes de 08:00 a.m. a 01:00 p.m. y de 02:00 p.m. a 05:30 p.m.  Y los días sábados de 08:00 a.m. a 01:30 p.m. haciendo un total de cuarenta y ocho (48) horas semanales<br><br>

            <strong>Sexto.- </strong>La retribución que percibirá <strong>EL TRABAJADOR</strong> por todo concepto será de S/ {{$contrato->remuneracion}} NUEVOS SOLES mensuales, de la cual se deducirá las aportaciones y tributos establecidos en la ley que le resulten de aplicación.<br><br>

            <strong>Séptimo.-</strong> <strong>EL TRABAJADOR</strong> se compromete a desarrollar para el empleador toda su capacidad de trabajo en el desempeño de sus labores, así como cumplir con las normas contenidas en el Reglamento Interno de Trabajo de La Empresa, las del Reglamento de Seguridad e Higiene Ocupacional, y las órdenes que imparta <strong>EL EMPLEADOR</strong> en ejercicio de las facultades conferidas en el Art. 9º de la Ley de Productividad y Competitividad Laboral, TUO del D.Leg. 728 aprobado por D.S. 003-97-TR.<br><br>

            <strong>Octavo.-</strong><strong>EL EMPLEADOR</strong> se obliga a inscribir a <strong>EL TRABAJADOR</strong> en el libro de planillas de Remuneraciones, así como poner en conocimiento de la Autoridad Administrativa de Trabajo a el presente contrato, para su conocimiento y registro, en cumplimiento de lo dispuesto por el articulo 73º del Texto Unico Ordenado del Decreto Legislativo 728, la Ley de Productividad y Competitividad Laboral, aprobado mediante Decreto Supremo Nº 003-97-TR. <br><br>

            <strong>Noveno.- </strong>Queda entendido que <strong>EL EMPLEADOR</strong>  no está obligado a dar aviso adicional alguno referente al término del presente contrato, el que concluye de acuerdo a la cláusula cuarta, oportunidad en la cual se abonará a <strong>EL TRABAJADOR</strong> los Beneficios Sociales que le pudieran corresponder de acuerdo a Ley;<br><br>

            <strong>Décimo.- </strong>Este contrato queda sujeto a las disposiciones que contiene el TUO del Decreto Legislativo Nº 728 aprobado por  D.S. 003-97-TR  Ley de Productividad y Competitividad Laboral, y demás normas legales que lo regulen o que sean dictadas durante la vigencia del contrato. <br><br>

            Como muestra de conformidad con todas las cláusulas del presente contrato firman las partes, por duplicado a  los 01 días de NOVIEMBRE del año 2018.





               
                <p class="trabajador">EL TRABAJADOR</p>            <p class="empresa">LA EMPRESA</p> 




        </article>

    </section>

</body>
</html>