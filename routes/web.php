<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/********************** USUARIOS *************************/

Route::group(['middleware' => ['guestaw']], function () {

	Route::any('/', 'UserController@actionLogin');
	Route::any('/login', 'UserController@actionLogin');
	Route::any('/ajax-select-local', 'GeneralAjaxController@actionLocalAjax');

}); 

Route::get('/cerrarsession', 'UserController@actionCerrarSesion');

Route::any('/marcacion', 'MarcacionController@actionMarcacion');
Route::any('/ajax-marcar-asistencia', 'MarcacionController@actionMarcarAsistenciaAjax');

Route::group(['middleware' => ['authaw']], function () {

	Route::get('/bienvenido', 'UserController@actionBienvenido');

	Route::any('/gestion-de-usuarios/{idopcion}', 'UserController@actionListarUsuarios');
	Route::any('/agregar-usuario/{idopcion}', 'UserController@actionAgregarUsuario');
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', 'UserController@actionModificarUsuario');

	Route::any('/ajax-dato-del-trabajador', 'UserController@actionDatoTrabajador');

	Route::any('/gestion-de-roles/{idopcion}', 'UserController@actionListarRoles');
	Route::any('/agregar-rol/{idopcion}', 'UserController@actionAgregarRol');
	Route::any('/modificar-rol/{idopcion}/{idrol}', 'UserController@actionModificarRol');

	Route::any('/gestion-de-permisos/{idopcion}', 'UserController@actionListarPermisos');
	Route::any('/ajax-listado-de-opciones', 'UserController@actionAjaxListarOpciones');
	Route::any('/ajax-activar-permisos', 'UserController@actionAjaxActivarPermisos');

	Route::any('/gestion-de-trabajador/{idopcion}', 'TrabajadorController@actionListarTrabajador');

	Route::any('/agregar-trabajador/{idopcion}', 'TrabajadorController@actionAgregarTrabajador'); 
	Route::any('/ajax-baja-del-trabajador', 'TrabajadorController@actionDatoBajaTrabajador');
	Route::any('/modificar-trabajador/{idopcion}/{idtrabajador}', 'TrabajadorController@actionModificarTrabajador');
	

	Route::any('/ficha-contrato-trabajador/{idopcion}/{idtrabajador}', 'ContratoController@actionContrato');
	Route::any('/modificar-ficha-contrato-trabajador/{idcontrato}/{idopcion}/{idtrabajador}', 'ContratoController@actionModificarContrato');
	Route::any('/contrato-trabajador-pdf/{idcontrato}', 'ContratoReporteController@actionContratoPdf');

	Route::any('/ajax-form-contrato', 'ContratoController@actionContratoAjax');
	Route::any('/ajax-modal-contrato', 'ContratoController@actionContratoModalAjax'); 

	Route::any('/ajax-select-provincia', 'GeneralAjaxController@actionProvinciaAjax');
	Route::any('/ajax-select-distrito', 'GeneralAjaxController@actionDistritoAjax');

	Route::any('/ajax-select-area', 'GeneralAjaxController@actionAreaAjax');
	Route::any('/ajax-select-unidad', 'GeneralAjaxController@actionUnidadAjax');
	Route::any('/ajax-select-cargo', 'GeneralAjaxController@actionCargoAjax');

	Route::any('/ajax-select-tipoinstitucion', 'GeneralAjaxController@actionTipoInstitucionAjax');
	Route::any('/ajax-select-institucion', 'GeneralAjaxController@actionInstitucionAjax');
	Route::any('/ajax-select-carrera', 'GeneralAjaxController@actionCarreraAjax');

	Route::any('/ajax-select-area-empresa', 'GeneralAjaxController@actionAreaEmpresaAjax');

	Route::any('/ajax-select-area-horario-cargo-empresa-id', 'GeneralAjaxController@actionAreaHorarioCargoEmpresaIdAjax');
	Route::any('/ajax-select-local-empresa', 'GeneralAjaxController@actionLocalEmpresaAjax');
	Route::any('/baja-trabajador/{idopcion}/{idtrabajador}', 'TrabajadorController@actionBajaTrabajador');

	Route::any('/ajax-select-tipodocumentoacredita', 'GeneralAjaxController@actionTipoDocumentoAcreditaAjax');

	Route::any('/gestion-de-horario/{idopcion}', 'HorarioController@actionListarSemanas');
	Route::any('/ajax-listado-de-horario', 'HorarioController@actionAjaxListarHorario');
	Route::any('/ajax-listado-trabajadores-horario', 'HorarioController@actionAjaxListarTrabajadoresHorario');
	Route::any('/ajax-activar-horario-trabajador', 'HorarioController@actionAjaxActivarHorarioTrabajador');
	Route::any('/ajax-select-horario-trabajador', 'HorarioController@actionAjaxSelectHorarioTrabajador');
	Route::any('/ajax-clonar-horario', 'HorarioController@actionAjaxClonarHorario');
	Route::any('/ajax--copiar-horario-clonado', 'HorarioController@actionAjaxCopiarHorarioClonado');
	Route::any('/horario-semana-pdf/{idsemana}', 'HorarioReporteController@actionHorarioSemanaPdf');
	Route::any('/ajax-vacaciones-descanso-horario-trabajador', 'HorarioController@actionAjaxVacacionesDescansoHorarioTrabajador');
	Route::any('/ajax-baja-trabajador-horario', 'HorarioController@actionAjaxBajaTrabajadorHorario');	
	Route::any('/ajax-alta-trabajador-horario', 'HorarioController@actionAjaxAltaTrabajadorHorario');


	Route::any('/gestion-de-asistencia/{idopcion}', 'HorarioController@actionListarSemanasAsistencia');
	Route::any('/ajax-listado-de-horario-asistencia', 'HorarioController@actionAjaxListarHorarioAsistencia');
	Route::any('/ajax-modal-asistencia-trabajador', 'HorarioController@actionAjaxModalAsistenciaTrabajador');	
	Route::any('/ajax-actualizar-asistencia-trabajador', 'HorarioController@actionAjaxActualizarAsistenciaTrabajador');
	Route::any('/ajax-eliminar-asistencia-trabajador', 'HorarioController@actionAjaxEliminarAsistenciaTrabajador');	
	Route::any('/ajax-actualizar-tabla-asistencia', 'HorarioController@actionAjaxActualizarTablaAsistencia');

	/************************ Reportes **********************/

	Route::any('/reporte-horarios/{idopcion}', 'HorarioReporteController@actionHorarios');
	Route::any('/ajax-lista-horarios', 'HorarioReporteController@actionAjaxListaHorariosEmpresa');	
	Route::any('/horario-empresa-pdf/{idempresa}', 'HorarioReporteController@actionHorarioEmpresaPdf');
	Route::any('/reporte-asistencia-diaria/{idopcion}', 'HorarioReporteController@actionAsistenciaDiaria');//////////////////////////////////
	Route::any('/ajax-lista-asistencia-diaria', 'HorarioReporteController@actionAjaxListaAsistenciaDiaria');//////////////////////////////////
	Route::any('/horario-empresa-fecha-excel/{idsede}/{idempresa}/{fecha}', 'HorarioReporteController@actionHorarioEmpresaExcel');
	

	
	Route::any('/reporte-asistencia-diaria-mintra/{idopcion}', 'HorarioReporteController@actionAsistenciaDiariaMintra');
	Route::any('/ajax-lista-asistencia-diaria-mintra', 'HorarioReporteController@actionAjaxListaAsistenciaDiariaMintra');
	Route::any('/horario-mintra-empresa-fecha-excel/{idsede}/{idempresa}/{idarea}/{idtrabajador}/{fechainicio}/{fechafin}', 'HorarioReporteController@actionHorarioEmpresaMintraExcel');
	Route::any('/horario-mintra-empresa-fecha-pdf/{idsede}/{idempresa}/{idarea}/{idtrabajador}/{fechainicio}/{fechafin}', 'HorarioReporteController@actionHorarioEmpresaMintraPdf');


	Route::any('/reporte-asistencia-diaria-full/{idopcion}', 'HorarioReporteController@actionAsistenciaDiariaFull');
	Route::any('/ajax-lista-asistencia-diaria-full', 'HorarioReporteController@actionAjaxListaAsistenciaDiariaFull');
	Route::any('/horario-full-empresa-fecha-excel/{idsede}/{idempresa}/{fecha}', 'HorarioReporteController@actionHorarioEmpresaFullExcel');

	Route::any('/reporte-asistencia-individual/{idopcion}', 'HorarioReporteController@actionAsistenciaIndividual');
	Route::any('/ajax-lista-asistencia-individual', 'HorarioReporteController@actionAjaxListaAsistenciaIndividual');
	Route::any('/asistencia-individual-trabajador-fechas-excel/{idsede}/{idtrabajador}/{fechainicio}/{fechafin}', 'HorarioReporteController@actionAsistenciaIndividualTrabajadorFechasExcel');


	Route::any('/reporte-asistencia-individual-total/{idopcion}', 'HorarioReporteController@actionAsistenciaIndividualTotal');
	Route::any('/ajax-lista-asistencia-individual-total', 'HorarioReporteController@actionAjaxListaAsistenciaIndividualTotal');
	Route::any('/asistencia-individual-total-trabajador-fechas-excel/{idsede}/{idempresa}/{idarea}/{idtrabajador}/{fechainicio}/{fechafin}', 'HorarioReporteController@actionAsistenciaIndividualTotalTrabajadorFechasExcel');

	//Route::any('/ajax-lista-area-empresa', 'GeneralAjaxController@actionAjaxListaAreaEmpresa');

	Route::any('/ajax-select-area-empresa-todo', 'GeneralAjaxController@actionAreaEmpresaTodoAjax');
	Route::any('/ajax-select-sede-trabajadores-todo', 'GeneralAjaxController@actionSedeTrabajadoresTodoAjax');
	Route::any('/ajax-select-trabajador-area-empresa-todo', 'GeneralAjaxController@actionTrabajadorAreaEmpresaTodoAjax');

	Route::any('/reporte-asistencia-mensual/{idopcion}', 'HorarioReporteController@actionAsistenciaMensual');
	Route::any('/ajax-lista-asistencia-mensual', 'HorarioReporteController@actionAjaxListaAsistenciaMensual');
	Route::any('/asistencia-mensual-trabajador-fechas-excel/{idsede}/{idtrabajador}/{fechainicio}/{fechafin}', 'HorarioReporteController@actionAsistenciaMensualTrabajadorFechasExcel');

	Route::any('/reporte-asistencia-conductores/{idopcion}', 'ReportePilotoController@actionPilotoPeriodo');
	Route::any('/asistencia-conductores-excel/{idperiodo}/{idsede}', 'ReportePilotoController@actionAsistenciaPeriodoExcel');

	Route::any('/gestion-de-cargos/{idopcion}', 'MantenimientoController@actionListarCargos');
	Route::any('/agregar-cargo/{idopcion}', 'MantenimientoController@actionAgregarCargo');
	Route::any('/modificar-cargo/{idopcion}/{idcargo}', 'MantenimientoController@actionModificarCargo');

    //AGREGAR ASISTENCIA CONDUCTORES

	Route::any('/gestion-de-conductores/{idopcion}', 'AsistenciaConductorController@actionListarConductores');

	Route::any('/agregar-asistencia/{idopcion}', 'AsistenciaConductorController@actionAgregarAsistencia');

	Route::any('/lista-de-conductores-json.json', 'AsistenciaConductorController@actionListadeconductoresjson'); 


	//ASISTENCIA PERIODOS

	Route::any('/gestion-de-periodos/{idopcion}', 'MantenimientoController@actionListarPeriodo');
	Route::any('/ajax-lista-dias-periodo', 'MantenimientoController@actionAjaxListaDiasxPeriodo');	



});

	Route::any('/pruebas', 'UserController@pruebas');