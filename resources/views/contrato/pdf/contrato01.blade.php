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

        <h3 align="center">CONTRATO DE TRABAJO SUJETO A MODALIDAD POR NECESIDAD DE MERCADO</h3><br><br>

        <article class="contrato">


            Conste por el presente documento, el Contrato Individual de Trabajo, de Naturaleza Temporal por necesidades del Mercado, que celebran conforme al Art. 58º del D.S. 003-97-TR, Ley de Productividad y Competitividad Laboral, de una parte INDUAMERICA SERVICIOS LOGISTICOS SAC, con RUC Nº20479729141 y domicilio en CARRRETERA PANAMERICANA NORTE KM 775a la que se le denominará LA EMPRESA, representada por el señor SIXTO PERALES HUANCARUNA, identificado con DNI Nº 16722570; y de otra parte <font style="text-transform: uppercase;"> <strong>{{$contrato->trabajador->apellidopaterno}} {{$contrato->trabajador->apellidomaterno}},  {{$contrato->trabajador->nombres}}, </strong> </font>, al que en lo sucesivo se le designará como EL TRABAJADOR, identificado con DNI Nº {{$contrato->trabajador->dni}}, estado civil {{$contrato->trabajador->estadocivil->nombre}}, de (EDAD)de edad, de sexo (SEXO), con domicilio en {{$contrato->trabajador->tipovia->tipo}} {{$contrato->trabajador->nombrevia}}  {{$contrato->trabajador->numerovia}}, {{$contrato->trabajador->nombrezona}}, DISTRITO {{$contrato->trabajador->distrito->nombre}}, PROVINCIA {{$contrato->trabajador->provincia->nombre}}, DEPARTAMENTO {{$contrato->trabajador->departamento->nombre}}, en los términos y condiciones siguientes: <br><br>

            <strong>Primero.-</strong>La Empresa tiene como actividad principal el Servicios De Transporte De Carga Por Carretera (CIIU 6023)., que requiere las necesidades de recursos humanos con el objeto de atender los incrementos de la producción originados por la variación de la demanda en el mercado causado por el incremento de sus servicios en el mercado, debido al requerimiento de sus clientes, que hace necesario la contratación de personal para atender este incremento temporal y no previsto.<br><br>

            <strong>Segundo.-</strong> Por el presente documento el empleador contrata bajo la modalidad de NECESIDAD DE MERCADO Los servicios de EL TRABAJADOR, quien desempeñara el cargo de CONDUCTOR MASTER, en relación con las causas objetivas señaladas en la clausula anterior.<br><br>

            <strong>Tercero.-</strong> El plazo de vigencia del presente contrato es de TRES (03) MESES, el mismo que regirá a partir del {{$contrato->fechainicio}}  al {{$contrato->fechafin}}.<br><br>

            <strong>Cuarto.- </strong> La jornada de trabajo tendrá una duración de 48 horas semanales, en conformidad a lo establecido en el artículo primero del TUO DE LA LEY DE JORNADA DE TRABAJO, HORARIO Y TRABAJO EN SOBRETIEMPO (D.S. Nº 007-2002-TR.); Su distribución se efectuará de acuerdo a lo establecido en el Reglamento Interno de la empresa. <br><br>

            <strong>Quinto.- </strong> La retribución que percibirá El Trabajador será de  S/ {{$contrato->remuneracion}}  NUEVOS SOLES mensuales, de la cual se deducirá las aportaciones y descuentos por tributos establecidos en la ley que resulten aplicables.<br><br>

            <strong>Sexto.- </strong> El trabajador se compromete a desarrollar para el empleador toda su capacidad de trabajo en el desempeño de sus labores, así como cumplir con las normas contenidas en el Reglamento Interno de Trabajo de La Empresa, las del Reglamento de Seguridad e Higiene Ocupacional, y las órdenes que imparta La Empresa en ejercicio de las facultades conferidas en el Art. 9º de la Ley de Productividad y Competitividad Laboral.<br><br>

            <strong>Séptimo.-</strong> <strong>EL TRABAJADOR</strong> estará sujeto a las condiciones establecidas en el presente contrato, y en lo no dispuesto por él se rige por la Ley de Productividad y Competitividad Laboral.<br><br>

             <strong>Octavo.-</strong><strong>LA EMPRESA</strong> no está obligada a dar aviso adicional alguno referente al término del presente contrato, el que concluye de acuerdo a la cláusula tercera, oportunidad en la cual se abonará a El Trabajador los Beneficios Sociales que le corresponden de acuerdo a Ley.<br><br>

            <strong>Noveno.- </strong> La suspensión del contrato de trabajo por alguna de las causas previstas en el Art. 12º de la Ley de Productividad y Competitividad Laboral, TUO del D. Leg. 728, no interrumpirá el plazo de duración del presente Contrato.<br><br>
            Hecho en tres copias de un mismo tenor y para un solo efecto, los que se firman en CHICLAYO al FECHA ACTUAL.



               
                  <p class="trabajador">EL TRABAJADOR</p>            <p class="empresa">LA EMPRESA</p> 



        </article>

    </section>

</body>
</html>