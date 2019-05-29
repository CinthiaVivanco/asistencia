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

       <h3 align="center">CONTRATO INDIVIDUAL DE TRABAJO TEMPORAL POR INCREMENTO DE ACTIVIDAD</h3><br><br>

        <article class="contrato">


            Conste por el presente documento, el Contrato Individual de Trabajo, de Naturaleza Temporal por Incremento de Actividad, que celebran conforme al Art. 57º del TUO del D. Leg 728 aprobado por D.S. 003-97-TR Ley de Productividad y Competitividad Laboral, de una parte INDUAMERICA SERVICIOS LOGISTICOS SAC, con RUC Nº 20479729141, y domicilio en CARRETERA PANAMERICANA NORTE KM 775, a la que se le denominará LA EMPRESA/EMPLEADOR, representada por el señor Sixto Perales Huancaruna, identificado con DNI Nº 16722570; y de otra parte <font style="text-transform: uppercase;"> <strong>{{$contrato->trabajador->apellidopaterno}} {{$contrato->trabajador->apellidomaterno}},  {{$contrato->trabajador->nombres}}, </strong> </font> al que en lo sucesivo se le designará como EL TRABAJADOR, identificado con DNI Nº {{$contrato->trabajador->dni}} estado civil {{$contrato->trabajador->estadocivil->nombre}}, de (EDAD)de edad, de sexo (SEXO), con domicilio en {{$contrato->trabajador->tipovia->tipo}} {{$contrato->trabajador->nombrevia}}  {{$contrato->trabajador->numerovia}}, {{$contrato->trabajador->nombrezona}}, DISTRITO {{$contrato->trabajador->distrito->nombre}}, PROVINCIA {{$contrato->trabajador->provincia->nombre}}, DEPARTAMENTO {{$contrato->trabajador->departamento->nombre}}, en los términos y condiciones siguientes:<br><br>

            <strong>Primero.-</strong> La Empresa tiene como actividad principal el Servicios De Transporte De Carga Por Carretera (CIIU 6023).<br><br>

            <strong>Segundo.-</strong> La Empresa tiene la necesidad de contratar personal el cual brinden un servicio de apoyo a los conductores asignados a las unidades adquiridas (camiones) vía arrendamiento financiero en la ciudad de lima, el cual realizara las funciones del cuidado de la carga y descarga de mercadería, así como aquéllos funciones que se deriven de su labor y cargo.<br><br>

            <strong>Tercero.-</strong> En razón de las causas objetivas señaladas en la cláusula anterior, La Empresa contrata a plazo fijo bajo la modalidad indicada, los servicios de EL TRABAJADOR para que realice las labores de {{$contrato->cargo->nombre}}; sin embargo EL EMPLEADOR está facultado a efectuar modificaciones razonables en función a la capacidad y aptitud del TRABAJADOR y a los requerimientos y necesidades de la empresa, sin que dichas variaciones signifiquen menoscabo de categoría o actos de hostilidad.<br><br>

            <strong>Cuarto.- </strong> El plazo de vigencia del presente contrato es de TRES (03) MESES, tiempo estimado para cubrir las necesidades a que se hace referencia en la cláusula segunda. La fecha de inicio es el {{$contrato->fechainicio}}, debiendo concluir el {{$contrato->fechafin}}.<br><br>

            <strong>Quinto.- </strong> En ejercicio de las facultades que la ley nos concede, y considerando que las labores y servicios que realiza EL TRABAJADOR en su cargo de  {{$contrato->cargo->nombre}}, corresponde a las actividades que realiza un trabajador no sujeto a fiscalización inmediata Por lo que su cargo ha sido calificado como trabajador NO SUJETO A FISCALIZACIÓN INMEDIATA.
            Asimismo, según lo establecido en el artículo 1º del D.S. Nº 004-2006-TR (06.04.2006), norma que regula el registro de control de asistencia y de salida en el régimen laboral de la actividad privada, los trabajadores no sujetos a fiscalización inmediata no se encuentran obligados a estar dentro del registro de asistencia, por tanto usted se encuentra exonerado de firmar el registro de asistencia.<br><br>

            <strong>Sexto.- </strong>La retribución que percibirá El Trabajador por todo concepto será de  MIL CUATROCIENTOS CINCUENTA CON 00 /100 NUEVOS SOLES (S/.{{$contrato->remuneracion}}.00) mensuales. <br><br>

            <strong>Séptimo.-</strong> El Trabajador podrá recibir mensualmente una Bonificación por producción, u otros beneficios extraordinarios, siempre y cuando cumpla con las condiciones, kilometraje y objetivos que establece El Empleador para la entrega de esta bonificación en cada periodo. <br><br>

            <strong>Octavo.-</strong> El trabajador se obliga a desempeñar la función de conducir vehículos motorizados destinados al transporte de carga terrestre a nivel nacional, de acuerdo a las instrucciones que al efecto sean impartidas por el empleador, así como cumplir con las normas contenidas en el Reglamento Interno de Trabajo de La Empresa, las del Reglamento de Seguridad e Higiene Ocupacional, y las ordenes que imparta la empresa en ejercicio de las facultades conferidas en el Art. 9º de la Ley de Productividad y Competitividad Laboral, TUO del D.Leg. 728. Además deberá ocuparse del cuidado y buen funcionamiento de los vehículos, sus accesorios, la mercadería o bienes puestos a su cargo.  Por tanto deberá comunicar al empleador, mediante la ficha que para dichos efectos le proporcione, las necesidades que al respecto se presenten a objeto de adoptar las medidas pertinentes, sin perjuicio de lo cual deberá ejecutar por sí mismo tareas básicas de mantenimiento, para lo cual el trabajador declara tener las habilidades necesarias. 
            El trabajador queda obligado a cumplir leal y correctamente con todos los deberes que se le impongan, siendo entre ellos actuar con la diligencia debida en el cuidado del vehículo y sus accesorios, en la recepción, custodia, traslado y entrega de las mercaderías o bienes que se le encomiende transportar, en el llenado, cuidado, presentación y entrega de toda la documentación que tenga relación con la propiedad del vehículo y de la mercadería y/o bienes  transportados; siendo responsable por causa imputable al trabajador, por el deterioro o destrucción de cualquier repuesto, implemento o accesorio de la unidad vehicular asignada a su cargo  o cuando algunos de los clientes, sancionen, penalicen o descuenten, a la EMPRESA por la entrega incompleta, tardía o en mal estado de los bienes transportados, o cuando la autoridad administrativa (MTC, SUNAT, SUTRAN, SUNAS, PNP U OTRAS) o judicial multe o sancione a la EMPRESA, por no presentar la documentación de los bienes transportados o estos se encuentran mal llenados o por alguna infracción a las normas de tránsito, cometidas por el trabajador. En cualquiera de estos supuestos u de otros en los que incurra el trabajador será pasible a los descuentos respectivos, autorizando a la firma este documento a que la empresa los realice de sus haberes por haber incumplido con sus obligaciones laborables, del reglamento o reglamentos de la empresa o con las instrucciones que le confieran sus superiores, sin que esto exonere de la sanción disciplinaria que pueda formular la EMPRESA. 
            Del mismo modo el trabajador se obliga a desempeñar en forma eficaz, las funciones y el cargo para el cual ha sido contratado, empleando para ello la mayor diligencia y dedicación.<br><br>

            <strong>Noveno.- </strong> El Trabajador estará sujeto a las condiciones del presente contrato y en lo no dispuesto por él se rige por la Ley de productividad y competitividad Laboral. <br><br>

           <strong>  Décimo- </strong> La Empresa no está obligada a dar aviso adicional alguno referente al término del presente contrato, el que concluye de acuerdo a la cláusula cuarta, oportunidad en la cual se abonará a El Trabajador los Beneficios Sociales que le corresponden de acuerdo a Ley;
            Décimo Primero.- La suspensión del contrato de trabajo por alguna de las causas previstas en el Art. 12º de la Ley de Productividad y Competitividad Laboral, TUO del D. Leg. 728, no interrumpirá el plazo de duración del presente Contrato.<br><br>

            <strong> Décimo Se</strong> gundo.- El empleador en su facultad de dirección y de acuerdo a la necesidad de la empresa, podrá introducir cambios o modificar turnos, días u horas de trabajo, así como la forma y modalidad de prestación de las labores, sin que esto constituya actos de hostilidad, y de lo cual El TRABAJADOR de manera expresa acepta, teniendo presente la actividad comercial de la EMPRESA, siendo su negativa considerada como una falta grave.<br><br>

            <strong> Décimo Te</strong> rcero.-El Trabajador declara que a la firma de este contrato ha recibido una copia del Reglamento interno de trabajo, del Reglamento de Seguridad e Higiene Ocupacional, Manual de Operaciones y los Estándares de Consumo de Combustible aprobados por el empleador y que forman parte integrante del  Reglamento interno de trabajo; comprometiéndose a cumplirlos fielmente, y autorizando al Empleador a efectuarle los descuentos pertinentes, cuando ante la inobservancia de los Reglamentos por parte del Trabajador traiga consigo un perjuicio económico para el empleador; no siendo necesario ningún otro documento que autorice tal descuento.<br><br>

            En señal de conformidad a todo lo pactado las partes lo suscriben en dos copias de un mismo tenor y para un solo efecto, en CHICLAYO  a los 01 días de NOVIEMBRE del 2018.<br><br>
                






               
                <p class="trabajador">EL TRABAJADOR</p>            <p class="empresa">LA EMPRESA</p> 




        </article>

    </section>

</body>
</html>