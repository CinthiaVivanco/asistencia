<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Semana,App\Trabajador,App\Horario,App\Horariotrabajador,App\Asistenciatrabajador,App\Horarioempresa,App\Empresa,App\Local;
use App\Horariotrabajadoresclonado,App\Permisouserempresa;
use View;
use Session;
use Hashids;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use TPDF;


class HorarioReporteController extends Controller
{




	public function actionAsistenciaMensual($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
		$combotrabajador 	= 	array('' => "Seleccione trabajador");

		$combosede			= 	$this->funciones->combopermisossedes();
	

		return View::make('horario/reporte/asistenciamensual',
						 [
						 	'idopcion' 			=> $idopcion,
							'combotrabajador' 	=> $combotrabajador,
							'combosede' 		=> $combosede,							
							'inicio'			=> $this->inicio,
							'hoy'				=> $this->fin,
						 ]);

	}


	public function actionAjaxListaAsistenciaMensual(Request $request)
	{

		set_time_limit(0);
		$trabajador_id 			=  	$request['trabajador_id'];
		$fechainicio 			=  	date_format(date_create($request['fechainicio']), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($request['fechafin']), 'Y-m-d');
		$sede_id 				=  	$request['sede_id'];


		if($trabajador_id <> '1'){
			$trabajador_id 			= 	$this->funciones->decodificar($trabajador_id);			
		}


		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;

		$titulo 				=   'ASISTENCIA MENSUAL';


		if($trabajador_id <> '1'){

			$arraytrabajadores		=   $this->funciones->arraytrabajadoresaltabaja($trabajador_id);


			$listaasistencia        =   Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)
										->whereIn('semana_id',$arraysemanas)
										->orderBy('semana_id', 'asc')
									    ->get();		
		}else{
			
			$arraytrabajadores 		=   $this->funciones->arraysedetrabajadorespermiso($sede_id);
			

			$listaasistencia        =   Horariotrabajador::whereIn('semana_id',$arraysemanas)
										->join('trabajadores','trabajadores.id','=','horariotrabajadores.trabajador_id')
										->select('horariotrabajadores.*')
										->whereIn('trabajador_id',$arraytrabajadores)
										->orderBy('trabajadores.apellidopaterno', 'asc')
										->orderBy('semana_id', 'asc')
									    ->get();

		}


		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;		


		return View::make('horario/ajax/listaasistenciamensual',
						 [
							 'listaasistencia'   	=> $listaasistencia,
							 'titulo'   	  		=> $titulo,
							 'fechainicio'			=> $fechainicio,
							 'fechafin'				=> $fechafin,
							 'horario'				=> $horario,
							 'funcion'				=> $funcion					 							 							 						 					 
						 ]);

	}



	public function actionAsistenciaMensualTrabajadorFechasExcel($sede_id,$trabajador_id,$fechainicio,$fechafin)
	{
		set_time_limit(0);
		$trabajador_id 			=  	$trabajador_id;
		$sede_id 				=  	$sede_id;		
		$fechainicio 			=  	date_format(date_create($fechainicio), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($fechafin), 'Y-m-d');

		if($trabajador_id <> '1'){
			$trabajador_id 			= 	$this->funciones->decodificar($trabajador_id);			
		}


		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;

		$titulo 				=   'ASISTENCIA MENSUAL';



		if($trabajador_id <> '1'){

			$arraytrabajadores		=   $this->funciones->arraytrabajadoresaltabaja($trabajador_id);


			$listaasistencia        =   Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)
										->whereIn('semana_id',$arraysemanas)
										->orderBy('semana_id', 'asc')
									    ->get();		
		}else{
			
				$arraytrabajadores 		=   $this->funciones->arraysedetrabajadorespermiso($sede_id);
			
			$listaasistencia        =   Horariotrabajador::whereIn('semana_id',$arraysemanas)
										->join('trabajadores','trabajadores.id','=','horariotrabajadores.trabajador_id')
										->select('horariotrabajadores.*')
										->whereIn('trabajador_id',$arraytrabajadores)
										->orderBy('trabajadores.apellidopaterno', 'asc')
										->orderBy('semana_id', 'asc')
									    ->get();										    
		}

		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;	


	    Excel::create($titulo.' ('.$fechainicio.' - '.$fechafin.')', function($excel) use ($listaasistencia,$titulo,$fechainicio,$fechafin,$horario,$funcion) {

	        $excel->sheet('Asistencias Mensual', function($sheet) use ($listaasistencia,$titulo,$fechainicio,$fechafin,$horario,$funcion) {

	            $sheet->loadView('horario/excel/listaasistenciamensual')->with('listaasistencia',$listaasistencia)
	                                         		 ->with('titulo',$titulo)
	                                         		 ->with('fechainicio',$fechainicio)
	                                         		 ->with('fechafin',$fechafin)
	                                         		 ->with('horario',$horario)
	                                         		 ->with('funcion',$funcion);	                                         		 
	        });
	    })->export('xls');

	}


	public function actionAsistenciaIndividualTotal($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $arrayempresa   	= 	$this->funciones->arrayempresapermiso();
		$empresa 			= 	DB::table('empresas')->whereIn('id',$arrayempresa)->where('activo','=','0')->pluck('descripcion','id')->toArray();
		$comboempresa 		= 	$this->funciones->comboidencriptado($empresa,'Seleccione empresa');

		$comboarea 			= 	['' => 'Seleccione Area'];
		$combotrabajador 	= 	['' => 'Seleccione trabajador'];
		$combosede			= 	$this->funciones->combopermisossedes();


		return View::make('horario/reporte/asistenciaindividualtotal',
						 [
						 	'idopcion' 			=> $idopcion,
							'comboarea' 		=> $comboarea,
							'comboempresa' 		=> $comboempresa,													 	
							'combotrabajador' 	=> $combotrabajador,
							'combosede' 		=> $combosede,							
							'inicio'			=> $this->inicio,
							'hoy'				=> $this->fin,
						 ]);
	}



	public function actionAjaxListaAsistenciaIndividualTotal(Request $request)
	{

		set_time_limit(0);
		$empresa_id 			=  	$request['empresa_id'];
		$area_id 				=  	$request['area_id'];
		$sede_id 				=  	$request['sede_id'];		
		$trabajador_id 			=  	$request['trabajador_id'];
		$fechainicio 			=  	date_format(date_create($request['fechainicio']), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($request['fechafin']), 'Y-m-d');
		$empresa_id 			= 	$this->funciones->decodificarmaestra($empresa_id);
		if($area_id <> '1'){
			$area_id 			= 	$this->funciones->decodificarmaestra($area_id);			
		}
		if($trabajador_id <> '1'){
			$trabajador_id 		= 	$this->funciones->decodificar($trabajador_id);			
		}

		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;
		$titulo 				=   'ASISTENCIA INDIVIDUAL TOTAL';
		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;

		if($trabajador_id <> '1'){

			$trabajador           	=   Trabajador::where('id','=',$trabajador_id)->get();

		}else{

			$arrayareas				= 	DB::table('areas')->where('id','=',$area_id)->pluck('id')->toArray();
			$arrayareas    			= 	$this->funciones->arrayareastrabajador($area_id,$empresa_id) ;
				$arraytrabajadores 		=   $this->funciones->arraysedeempresatrabajadores($sede_id,$empresa_id);
		
			$trabajador 			=   Trabajador::where('activo','=',1)
										->whereIn('area_id',$arrayareas)
										->whereIn('id',$arraytrabajadores)
										->where('activo','=','1')
										->orderBy('apellidopaterno', 'asc')
										->get();								
		}

		$empresa 					=   Empresa::where('id','=',$empresa_id)->first();


		return View::make('horario/ajax/listaasistenciaindividualestotal',
						 [
							 'titulo'   	  		=> $titulo,
							 'trabajador'   	  	=> $trabajador,
							 'empresa'   	  		=> $empresa,
							 'arraysemanas'			=> $arraysemanas,
							 'fechainicio'			=> $fechainicio,
							 'fechafin'				=> $fechafin,
							 'horario'				=> $horario,
							 'funcion'				=> $funcion					 							 							 						 					 
						 ]);

	}




	public function actionAsistenciaIndividualTotalTrabajadorFechasExcel($sede_id,$empresa_id,$area_id,$trabajador_id,$fechainicio,$fechafin)
	{

		set_time_limit(0);
		$empresa_id 			=  	$empresa_id;
		$area_id 				=  	$area_id;
		$trabajador_id 			=  	$trabajador_id;
		$fechainicio 			=  	date_format(date_create($fechainicio), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($fechafin), 'Y-m-d');
		$empresa_id 			= 	$this->funciones->decodificarmaestra($empresa_id);
		if($area_id <> '1'){
			$area_id 			= 	$this->funciones->decodificarmaestra($area_id);			
		}
		if($trabajador_id <> '1'){
			$trabajador_id 		= 	$this->funciones->decodificar($trabajador_id);			
		}

		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;

		$titulo 				=   'ASISTENCIA INDIVIDUAL TOTAL';

		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;



		if($trabajador_id <> '1'){
			$trabajador           	=   Trabajador::where('id','=',$trabajador_id)->get();

		}else{

			$arrayareas    			= 	$this->funciones->arrayareastrabajador($area_id,$empresa_id) ;
				$arraytrabajadores 		=   $this->funciones->arraysedeempresatrabajadores($sede_id,$empresa_id);

			$trabajador 			=   Trabajador::where('activo','=',1)
										->whereIn('area_id',$arrayareas)
										->whereIn('id',$arraytrabajadores)										
										->where('activo','=','1')
										->orderBy('apellidopaterno', 'asc')
										->get();								
		}

		$empresa 					=   Empresa::where('id','=',$empresa_id)->first();


	    Excel::create($titulo.' ('.$fechainicio.' - '.$fechafin.')', function($excel) use ($titulo,$trabajador,$fechainicio,$fechafin,$horario,$funcion,$arraysemanas,$empresa) {

	        $excel->sheet('Asistencias individual totales', function($sheet) use ($titulo,$trabajador,$fechainicio,$fechafin,$horario,$funcion,$arraysemanas,$empresa) {

	            $sheet->loadView('horario/excel/listaasistenciaindividualestotal')->with('arraysemanas',$arraysemanas)
	                                         		 ->with('titulo',$titulo)
	                                         		 ->with('trabajador',$trabajador)
	                                         		 ->with('fechainicio',$fechainicio)
	                                         		 ->with('fechafin',$fechafin)
	                                         		 ->with('horario',$horario)
	                                         		 ->with('empresa',$empresa)
	                                         		 ->with('funcion',$funcion);	                                         		 
	        });
	    })->export('xls');
	}




	public function actionAsistenciaIndividual($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		$combotrabajador 	= 	array('' => "Seleccione trabajador");

		$combosede			= 	$this->funciones->combopermisossedes();

		return View::make('horario/reporte/asistenciaindividual',
						 [
						 	'idopcion' 			=> $idopcion,
							'combotrabajador' 	=> $combotrabajador,
							'combosede' 		=> $combosede,							
							'inicio'			=> $this->inicio,
							'hoy'				=> $this->fin,
						 ]);
	}

	public function actionAjaxListaAsistenciaIndividual(Request $request)
	{

		set_time_limit(0);
		$trabajador_id 			=  	$request['trabajador_id'];
		$sede_id 				=  	$request['sede_id'];

		$fechainicio 			=  	date_format(date_create($request['fechainicio']), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($request['fechafin']), 'Y-m-d');

		if($trabajador_id <> '1'){
			$trabajador_id 			= 	$this->funciones->decodificar($trabajador_id);			
		}

		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;

		$titulo 				=   'ASISTENCIA INDIVIDUAL';

		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;

		if($trabajador_id <> '1'){

			$arraytrabajadores		=   $this->funciones->arraytrabajadoresaltabaja($trabajador_id);

			$trabajador           	=   Trabajador::where('id','=',$trabajador_id)->get();

		}else{

			$arraytrabajadores 		= 	Horariotrabajador::whereIn('semana_id',$arraysemanas)
	                                      				 ->pluck('trabajador_id')->toArray();

			$arraylocales   		= 	$this->funciones->arraylocalessedepermiso($sede_id);
								

			$trabajador           	=   Trabajador::whereIn('id',$arraytrabajadores)
										->whereIn('local_id',$arraylocales)
										->orderBy('apellidopaterno', 'asc')
										->get();
	

		}


		return View::make('horario/ajax/listaasistenciaindividuales',
						 [
							 'titulo'   	  		=> $titulo,
							 'trabajador'   	  	=> $trabajador,
							 'arraysemanas'			=> $arraysemanas,
							 'fechainicio'			=> $fechainicio,
							 'fechafin'				=> $fechafin,
							 'horario'				=> $horario,
							 'funcion'				=> $funcion					 							 							 						 					 
						 ]);

	}
	public function actionAsistenciaIndividualTrabajadorFechasExcel($sede_id,$trabajador_id,$fechainicio,$fechafin)
	{

		set_time_limit(0);
		$trabajador_id 			=  	$trabajador_id;
		$fechainicio 			=  	date_format(date_create($fechainicio), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($fechafin), 'Y-m-d');

		if($trabajador_id <> '1'){
			$trabajador_id 			= 	$this->funciones->decodificar($trabajador_id);			
		}

		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;

		$titulo 				=   'ASISTENCIA INDIVIDUAL';

		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;

		if($trabajador_id <> '1'){
			$trabajador           	=   Trabajador::where('id','=',$trabajador_id)->get();
		}else{
			$arraytrabajadores 		= 	Horariotrabajador::whereIn('semana_id',$arraysemanas)
	                                      				 ->pluck('trabajador_id')->toArray();
			$arraylocales   		= 	$this->funciones->arraylocalessedepermiso($sede_id);
								
			$trabajador           	=   Trabajador::whereIn('id',$arraytrabajadores)
										->whereIn('local_id',$arraylocales)
										->orderBy('apellidopaterno', 'asc')
										->get();

		}


	    Excel::create($titulo.' ('.$fechainicio.' - '.$fechafin.')', function($excel) use ($titulo,$trabajador,$fechainicio,$fechafin,$horario,$funcion,$arraysemanas) {

	        $excel->sheet('Asistencias individuales', function($sheet) use ($titulo,$trabajador,$fechainicio,$fechafin,$horario,$funcion,$arraysemanas) {

	            $sheet->loadView('horario/excel/listaasistenciaindividuales')->with('arraysemanas',$arraysemanas)
	                                         		 ->with('titulo',$titulo)
	                                         		 ->with('trabajador',$trabajador)
	                                         		 ->with('fechainicio',$fechainicio)
	                                         		 ->with('fechafin',$fechafin)
	                                         		 ->with('horario',$horario)
	                                         		 ->with('funcion',$funcion);	                                         		 
	        });
	    })->export('xls');
	}



	public function actionHorarioEmpresaFullExcel($idsede,$idempresa,$fecha)
	{
		set_time_limit(0);
		$idempresa 				=  	$idempresa;
		$fecha 					=  	$fecha;		
		$idempresa 				= 	$this->funciones->decodificarmaestra($idempresa);
		$idsemana               =   $this->funciones->idsemana($fecha);
		$nombredia              =   $this->funciones->nombredia($fecha);

		$titulo 				=   'CONTROL DE ASISTENCIA FULL';
		$empresa           		=   Empresa::where('id','=',$idempresa)->first();

		//$arraylocales			=   Local::where('empresa_id','=',$idempresa)->pluck('id')->toArray();
	    $arraylocales   		= 	$this->funciones->arraylocalessedesempresapermiso($idsede,$idempresa);		
		$arraytrabajadores      =   Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();

		$listaasistencia        =   Horariotrabajador::where('semana_id','=',$idsemana)
									->join('trabajadores','trabajadores.id','=','horariotrabajadores.trabajador_id')
									->select('trabajadores.nombres','horariotrabajadores.*')
									->whereIn('trabajador_id',$arraytrabajadores)
									->whereIn('trabajador_id',$arraytrabajadores)
									//->where($nombredia.'h','=',1)
									->orderBy('trabajadores.apellidopaterno','asc')
								    ->get();


		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    

		$mi 					=   $nombredia.'mi';
		$mf 					=   $nombredia.'mf';
		$mri 					=   $nombredia.'mri';
		$mrf 					=   $nombredia.'mrf';
		$hhorario 				=   'h'.$nombredia;						
		$funcion 				= 	$this;		
		$diafecha 				=   $nombredia.'d';

	    Excel::create($titulo.' ('.$fecha.')', function($excel) use ($listaasistencia,$mi,$mf,$mri,$mrf,$titulo,$empresa,$fecha,$horario,$hhorario,$funcion,$diafecha) {

	        $excel->sheet('Asistencias diarias', function($sheet) use ($listaasistencia,$mi,$mf,$mri,$mrf,$titulo,$empresa,$fecha,$horario,$hhorario,$funcion,$diafecha) {

	            $sheet->loadView('horario/excel/listaasistenciadiariafull')->with('listaasistencia',$listaasistencia)
	                                         		 ->with('mi',$mi)
	                                         		 ->with('mf',$mf)
	                                         		 ->with('mri',$mri)
	                                         		 ->with('mrf',$mrf)
	                                         		 ->with('titulo',$titulo)
	                                         		 ->with('empresa',$empresa)
	                                         		 ->with('fecha',$fecha)
	                                         		 ->with('horario',$horario)
	                                         		 ->with('hhorario',$hhorario)
	                                         		 ->with('diafecha',$diafecha)
	                                         		 ->with('funcion',$funcion);	                                         		 
	            //$sheet->setOrientation('landscape');
	        });

	    })->export('xls');

	}



	public function actionAjaxListaAsistenciaDiariaFull(Request $request)
	{
		set_time_limit(0);
		$idempresa 				=  	$request['idempresa'];
		$fecha 					=  	$request['fecha'];	
		$sede_id 				=  	$request['sede_id'];


		$idempresa 				= 	$this->funciones->decodificarmaestra($idempresa);
		$idsemana               =   $this->funciones->idsemana($fecha);
		$nombredia              =   $this->funciones->nombredia($fecha);

		$titulo 				=   'CONTROL DE ASISTENCIA';
		$empresa           		=   Empresa::where('id','=',$idempresa)->first();

		//$arraylocales			=   Local::where('empresa_id','=',$idempresa)->pluck('id')->toArray();
	    $arraylocales   		= 	$this->funciones->arraylocalessedesempresapermiso($sede_id,$idempresa);		
		$arraytrabajadores      =   Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();

		$listaasistencia        =   Horariotrabajador::where('semana_id','=',$idsemana)
									->join('trabajadores','trabajadores.id','=','horariotrabajadores.trabajador_id')
									->select('trabajadores.nombres','horariotrabajadores.*')
									->whereIn('trabajador_id',$arraytrabajadores)
									//->where($nombredia.'h','=',1)
									->orderBy('trabajadores.apellidopaterno','asc')
								    ->get();

		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    

		$mi 					=   $nombredia.'mi';
		$mf 					=   $nombredia.'mf';
		$mri 					=   $nombredia.'mri';
		$mrf 					=   $nombredia.'mrf';
		$hhorario 				=   'h'.$nombredia;
		$funcion 				= 	$this;		
		$diafecha 				=   $nombredia.'d';


		return View::make('horario/ajax/listaasistenciadiariafull',
						 [
							 'listaasistencia'   	=> $listaasistencia,
							 'titulo'   	  		=> $titulo,
							 'empresa'   	  		=> $empresa,
							 'fecha'				=> $fecha,	
							 'mi'					=> $mi,	
							 'mf'					=> $mf,
							 'mri'					=> $mri,
							 'mrf'					=> $mrf,
							 'horario'				=> $horario,
							 'hhorario'				=> $hhorario,
							 'diafecha'				=> $diafecha,
							 'funcion'				=> $funcion,					 							 							 						 					 
						 ]);



	}



	public function actionAsistenciaDiariaFull($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $arrayempresa   = $this->funciones->arrayempresapermiso();
		$empresa 		= DB::table('empresas')->whereIn('id',$arrayempresa)->where('activo','=','0')->pluck('descripcion','id')->toArray();
		$comboempresa 	= $this->funciones->comboidencriptado($empresa,'Seleccione empresa');

		$combosede		= $this->funciones->combopermisossedes();

		return View::make('horario/reporte/asistenciadiariafull',
						 [
						 	'idopcion' 		=> $idopcion,
							'comboempresa' 	=> $comboempresa,
							'combosede' 	=> $combosede,							
							'hoy'			=> $this->fin,
						 ]);

	}


	public function actionHorarioEmpresaMintraExcel($sede_id,$empresa_id,$area_id,$trabajador_id,$fechainicio,$fechafin)
	{

		set_time_limit(0);
		$empresa_id 			=  	$empresa_id;
		$area_id 				=  	$area_id;
		$sede_id 				=  	$sede_id;		
		$trabajador_id 			=  	$trabajador_id;
		$fechainicio 			=  	date_format(date_create($fechainicio), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($fechafin), 'Y-m-d');
		$empresa_id 			= 	$this->funciones->decodificarmaestra($empresa_id);
		if($area_id <> '1'){
			$area_id 			= 	$this->funciones->decodificarmaestra($area_id);			
		}

		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;
		$titulo 				=   'CONTROL DE ASISTENCIA MINTRA';
		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;

		if($trabajador_id <> '1'){
			$trabajador_id 		= 	$this->funciones->decodificar($trabajador_id);	
			$trabajador           	=   Trabajador::where('id','=',$trabajador_id)->get();
		}else{

			$arrayareas				= 	DB::table('areas')->where('id','=',$area_id)->pluck('id')->toArray();
			$arrayareas    			= 	$this->funciones->arrayareastrabajador($area_id,$empresa_id) ;
				$arraytrabajadores 		=   $this->funciones->arraysedeempresatrabajadores($sede_id,$empresa_id);
		
			$trabajador 			=   Trabajador::where('activo','=',1)
										->whereIn('area_id',$arrayareas)
										->whereIn('id',$arraytrabajadores)
										->where('activo','=','1')
										->orderBy('apellidopaterno', 'asc')
										->get();								
		}

		$empresa 					=   Empresa::where('id','=',$empresa_id)->first();
		$horario 					= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    


	

	    Excel::create($titulo.' ('.$fechainicio.' / '.$fechafin.')', function($excel) use ($trabajador,$titulo,$empresa,$fechainicio,$fechafin,$horario,$funcion,$arraysemanas) {

	        $excel->sheet('Asistencias diarias', function($sheet) use ($trabajador,$titulo,$empresa,$fechainicio,$fechafin,$horario,$funcion,$arraysemanas) {

	            $sheet->loadView('horario/excel/listaasistenciadiariamintra')->with('trabajador',$trabajador)
	                                         		 ->with('titulo',$titulo)
	                                         		 ->with('empresa',$empresa)
	                                         		 ->with('fechainicio',$fechainicio)
	                                         		 ->with('fechafin',$fechafin)
	                                         		 ->with('horario',$horario)
	                                         		 ->with('funcion',$funcion)
	                                         		 ->with('arraysemanas',$arraysemanas);	                                         		 
	            //$sheet->setOrientation('landscape');
	        });

	    })->export('xls');

	}


	public function actionHorarioEmpresaMintraPdf($sede_id,$empresa_id,$area_id,$trabajador_id,$fechainicio,$fechafin)
	{

		ini_set ("memory_limit", "-1");
		ini_set ('max_execution_time', 0);
		set_time_limit (0);
		$empresa_id 			=  	$empresa_id;
		$area_id 				=  	$area_id;
		$sede_id 				=  	$sede_id;		
		$trabajador_id 			=  	$trabajador_id;
		$fechainicio 			=  	date_format(date_create($fechainicio), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($fechafin), 'Y-m-d');
		$empresa_id 			= 	$this->funciones->decodificarmaestra($empresa_id);
		if($area_id <> '1'){
			$area_id 			= 	$this->funciones->decodificarmaestra($area_id);			
		}

		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;
		$titulo 				=   'CONTROL DE ASISTENCIA MINTRA';
		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;

		if($trabajador_id <> '1'){
			$trabajador_id 		= 	$this->funciones->decodificar($trabajador_id);	
			$trabajador           	=   Trabajador::where('id','=',$trabajador_id)->get();
		}else{

			$arrayareas				= 	DB::table('areas')->where('id','=',$area_id)->pluck('id')->toArray();
			$arrayareas    			= 	$this->funciones->arrayareastrabajador($area_id,$empresa_id) ;
				$arraytrabajadores 		=   $this->funciones->arraysedeempresatrabajadores($sede_id,$empresa_id);
		
			$trabajador 			=   Trabajador::where('activo','=',1)
										->whereIn('area_id',$arrayareas)
										->whereIn('id',$arraytrabajadores)
										->where('activo','=','1')
										->orderBy('apellidopaterno', 'asc')
										->get();								
		}

		$empresa 					=   Empresa::where('id','=',$empresa_id)->first();
		$horario 					= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    



		/****** PROBANDO REPORTE MINTA NUEVO PDF ************/


		// Sub-Header
		TPDF::SetTitle($titulo);

		TPDF::setFooterCallback(function($pdf) {

		        // Position at 15 mm from bottom
		        $pdf->SetY(-15);
		        // Set font
		        $pdf->SetFont('helvetica', 'I', 8);
		        // Page number
		        $pdf->Cell(0, 10, 'Página '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

		});
		$rows = $this->funciones->emcabezadopdf($empresa,$fechainicio,$fechafin);
		$primero = 0;
		$cantidad = 66;
		$cantidadreset = 66;		
		$cantidadprimero = 56;

		foreach($trabajador as $itemt){ // iniciar bucle para agregar
			$listaasistencia        =   $this->funciones->reportemintra($itemt->id,$arraysemanas);
			foreach($listaasistencia as $index => $item){ // iniciar bucle para agregar

					// LUNES

					$fecha  		=   $item->asistenciatrabajador->lud;

					if($fecha >= $fechainicio && $fecha <= $fechafin){
				      	$this->funciones->detallepdf($fecha,$item,$index,$horario,$rows);
		                $rows ++; // incrementa con 1 después de cada datarow
		                if($primero == 0){$cantidad=$cantidadprimero;}
		                $rows = $this->funciones->emcabezadopdfdetalle($rows,$cantidad);
		                if($rows <= 0){$primero=1; $cantidad=$cantidadreset;}

					}



					// MARTES
					$fecha  		=   $item->asistenciatrabajador->mad;

					if($fecha >= $fechainicio && $fecha <= $fechafin){
				      	$this->funciones->detallepdf($fecha,$item,$index,$horario,$rows);
		                $rows ++; // incrementa con 1 después de cada datarow
		                if($primero == 0){$cantidad=$cantidadprimero;}
		                $rows = $this->funciones->emcabezadopdfdetalle($rows,$cantidad);
		                if($rows <= 0){$primero=1; $cantidad=$cantidadreset;}	                
					}

					// MIERCOLES
					$fecha  		=   $item->asistenciatrabajador->mid;

					if($fecha >= $fechainicio && $fecha <= $fechafin){
				      	$this->funciones->detallepdf($fecha,$item,$index,$horario,$rows);
		                $rows ++; // incrementa con 1 después de cada datarow
		                if($primero == 0){$cantidad=$cantidadprimero;}
		                $rows = $this->funciones->emcabezadopdfdetalle($rows,$cantidad);
		                if($rows <= 0){$primero=1; $cantidad=$cantidadreset;}	                
					}

					// JUEVES
					$fecha  		=   $item->asistenciatrabajador->jud;

					if($fecha >= $fechainicio && $fecha <= $fechafin){
				      	$this->funciones->detallepdf($fecha,$item,$index,$horario,$rows);
		                $rows ++; // incrementa con 1 después de cada datarow
		                if($primero == 0){$cantidad=$cantidadprimero;}
		                $rows = $this->funciones->emcabezadopdfdetalle($rows,$cantidad);
		                if($rows <= 0){$primero=1; $cantidad=$cantidadreset;}	                
					}

					// VIERNES
					$fecha  		=   $item->asistenciatrabajador->vid;

					if($fecha >= $fechainicio && $fecha <= $fechafin){
				      	$this->funciones->detallepdf($fecha,$item,$index,$horario,$rows);
		                $rows ++; // incrementa con 1 después de cada datarow
		                if($primero == 0){$cantidad=$cantidadprimero;}
		                $rows = $this->funciones->emcabezadopdfdetalle($rows,$cantidad);
		                if($rows <= 0){$primero=1; $cantidad=$cantidadreset;}		                
					}

					// SABADO
					$fecha  		=   $item->asistenciatrabajador->sad;

					if($fecha >= $fechainicio && $fecha <= $fechafin){
				      	$this->funciones->detallepdf($fecha,$item,$index,$horario,$rows);
		                $rows ++; // incrementa con 1 después de cada datarow
		                if($primero == 0){$cantidad=$cantidadprimero;}
		                $rows = $this->funciones->emcabezadopdfdetalle($rows,$cantidad);
		                if($rows <= 0){$primero=1; $cantidad=$cantidadreset;}	                
					}

					// DOMINGO

					$fecha  		=   $item->asistenciatrabajador->dod;

					if($fecha >= $fechainicio && $fecha <= $fechafin){
				      	$this->funciones->detallepdf($fecha,$item,$index,$horario,$rows);
		                $rows ++; // incrementa con 1 después de cada datarow
		                if($primero == 0){$cantidad=$cantidadprimero;}
		                $rows = $this->funciones->emcabezadopdfdetalle($rows,$cantidad);
		                if($rows <= 0){$primero=1; $cantidad=$cantidadreset;}		                
					}

                                  
	        }
	    }




		TPDF::Output('download.pdf');
	}





	public function actionAsistenciaDiariaMintra($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
		
	    $fecha = Carbon::createFromFormat('Y-m-d H:i:s', '2000-01-01 08:00:00')->addYear()->toDateTimeString();

	    $arrayempresa   = $this->funciones->arrayempresapermiso();
		$empresa 		= DB::table('empresas')->whereIn('id',$arrayempresa)->where('activo','=','0')->pluck('descripcion','id')->toArray();
		$comboempresa 	= $this->funciones->comboidencriptado($empresa,'Seleccione empresa');

		$comboarea 			= 	['' => 'Seleccione Area'];
		$combotrabajador 	= 	['' => 'Seleccione trabajador'];
		$combosede		= $this->funciones->combopermisossedes();

		return View::make('horario/reporte/asistenciadiariamintra',
						 [
						 	'idopcion' 		=> $idopcion,
							'comboempresa' 	=> $comboempresa,
							'combosede' 	=> $combosede,							
							'hoy'			=> $this->fin,
							'comboarea' 		=> $comboarea,
							'combotrabajador' 	=> $combotrabajador,
							'inicio'			=> $this->inicio							
						 ]);


	}






	public function actionAjaxListaAsistenciaDiariaMintra(Request $request)
	{
		set_time_limit(0);

		$empresa_id 			=  	$request['empresa_id'];
		$area_id 				=  	$request['area_id'];
		$sede_id 				=  	$request['sede_id'];		
		$trabajador_id 			=  	$request['trabajador_id'];
		$fechainicio 			=  	date_format(date_create($request['fechainicio']), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($request['fechafin']), 'Y-m-d');
		$empresa_id 			= 	$this->funciones->decodificarmaestra($empresa_id);
		if($area_id <> '1'){
			$area_id 			= 	$this->funciones->decodificarmaestra($area_id);			
		}

		$arraysemanas			=   $this->funciones->semanas($fechainicio,$fechafin) ;
		$titulo 				=   'CONTROL DE ASISTENCIA MINTRA';
		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$funcion 				= 	$this;

		if($trabajador_id <> '1'){

			$trabajador_id 			= 	$this->funciones->decodificar($trabajador_id);	
			$trabajador           	=   Trabajador::where('id','=',$trabajador_id)->get();

		}else{

			$arrayareas				= 	DB::table('areas')->where('id','=',$area_id)->pluck('id')->toArray();
			$arrayareas    			= 	$this->funciones->arrayareastrabajador($area_id,$empresa_id) ;
			$arraytrabajadores 		=   $this->funciones->arraysedeempresatrabajadores($sede_id,$empresa_id);
		


			$trabajador 			=   Trabajador::where('activo','=',1)
										->whereIn('area_id',$arrayareas)
										->whereIn('id',$arraytrabajadores)
										->where('activo','=','1')
										->orderBy('apellidopaterno', 'asc')
										->get();								
		}

		$empresa 					=   Empresa::where('id','=',$empresa_id)->first();
		$horario 					= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    


		return View::make('horario/ajax/listaasistenciadiariamintra',
						 [
							 'trabajador'   		=> $trabajador,
							 'titulo'   	  		=> $titulo,
							 'empresa'   	  		=> $empresa,
							 'fechainicio'			=> $fechainicio,							 
							 'fechafin'				=> $fechafin,	
							 'horario'				=> $horario,
							 'funcion'				=> $funcion,
							 'arraysemanas'			=> $arraysemanas,
						 ]);

	}



	public function actionHorarioEmpresaExcel($idsede,$idempresa,$fecha)
	{
		set_time_limit(0);
		$idempresa 				=  	$idempresa;
		$fecha 					=  	$fecha;		
		$idempresa 				= 	$this->funciones->decodificarmaestra($idempresa);
		$idsemana               =   $this->funciones->idsemana($fecha);
		$nombredia              =   $this->funciones->nombredia($fecha);

		$titulo 				=   'CONTROL DE ASISTENCIA';
		$empresa           		=   Empresa::where('id','=',$idempresa)->first();

		//$arraylocales			=   Local::where('empresa_id','=',$idempresa)->pluck('id')->toArray();
	    $arraylocales   		= 	$this->funciones->arraylocalessedesempresapermiso($idsede,$idempresa);

		$arraytrabajadores      =   Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();

		$listaasistencia        =   Horariotrabajador::where('semana_id','=',$idsemana)
									->join('trabajadores','trabajadores.id','=','horariotrabajadores.trabajador_id')
									->select('trabajadores.nombres','horariotrabajadores.*')
									->whereIn('trabajador_id',$arraytrabajadores)
									->where('horariotrabajadores.activo','=','1')
									//->where($nombredia.'h','=',1)
									->orderBy('trabajadores.apellidopaterno','asc')
								    ->get();



		$mi 					=   $nombredia.'mi';
		$mf 					=   $nombredia.'mf';
		$mri 					=   $nombredia.'mri';
		$mrf 					=   $nombredia.'mrf';						
		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();
		$hhorario 				=   'h'.$nombredia;
		$diafecha 				=   $nombredia.'d';
		$funcion 				= 	$this;

	    Excel::create($titulo.' ('.$fecha.')', function($excel) use ($listaasistencia,$mi,$mf,$mri,$mrf,$titulo,$empresa,$fecha,$horario,$hhorario,$diafecha,$funcion) {

	        $excel->sheet('Asistencias diarias', function($sheet) use ($listaasistencia,$mi,$mf,$mri,$mrf,$titulo,$empresa,$fecha,$horario,$hhorario,$diafecha,$funcion) {

	            $sheet->loadView('horario/excel/listaasistenciadiaria')->with('listaasistencia',$listaasistencia)
	                                         		 ->with('mi',$mi)
	                                         		 ->with('mf',$mf)
	                                         		 ->with('mri',$mri)
	                                         		 ->with('mrf',$mrf)
	                                         		 ->with('titulo',$titulo)
	                                         		 ->with('empresa',$empresa)
	                                         		 ->with('fecha',$fecha)
	                                         		 ->with('horario',$horario)
	                                         		 ->with('hhorario',$hhorario)
	                                         		 ->with('diafecha',$diafecha)
	                                         		 ->with('funcion',$funcion)	                                         		 ;	                                         		 
	            //$sheet->setOrientation('landscape');
	        });

	    })->export('xls');



	}




	public function actionAsistenciaDiaria($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $arrayempresa   = $this->funciones->arrayempresapermiso();
		$empresa 		= DB::table('empresas')->whereIn('id',$arrayempresa)->where('activo','=','0')->pluck('descripcion','id')->toArray();
		$comboempresa 	= $this->funciones->comboidencriptado($empresa,'Seleccione empresa');

		$combosede		= $this->funciones->combopermisossedes();

		return View::make('horario/reporte/asistenciadiaria',
						 [
						 	'idopcion' 		=> $idopcion,
							'comboempresa' 	=> $comboempresa,
							'combosede' 	=> $combosede,							
							'hoy'			=> $this->fin,
						 ]);

	}



	public function actionAjaxListaAsistenciaDiaria(Request $request)
	{
		set_time_limit(0);
		$idempresa 				=  	$request['idempresa'];
		$sede_id 				=  	$request['sede_id'];		
		$fecha 					=  	$request['fecha'];		
		$idempresa 				= 	$this->funciones->decodificarmaestra($idempresa);
		$idsemana               =   $this->funciones->idsemana($fecha);
		$nombredia              =   $this->funciones->nombredia($fecha);

		$titulo 				=   'CONTROL DE ASISTENCIA';
		$empresa           		=   Empresa::where('id','=',$idempresa)->first();

		//$arraylocales			=   Local::where('empresa_id','=',$idempresa)->pluck('id')->toArray();

	    $arraylocales   		= 	$this->funciones->arraylocalessedesempresapermiso($sede_id,$idempresa);

		$arraytrabajadores      =   Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();

		$listaasistencia        =   Horariotrabajador::where('semana_id','=',$idsemana)
									->join('trabajadores','trabajadores.id','=','horariotrabajadores.trabajador_id')
									->select('trabajadores.nombres','horariotrabajadores.*')
									->whereIn('trabajador_id',$arraytrabajadores)
									->where('horariotrabajadores.activo','=','1')
									//->where($nombredia.'h','=',1)
									->orderBy('trabajadores.apellidopaterno','asc')
								    ->get();

		$horario 				= 	Horario::all('nombre','id','horainicio','horafin','refrigerioinicio','refrigeriofin','marcacion')->toArray();							    
		$mi 					=   $nombredia.'mi';
		$mf 					=   $nombredia.'mf';
		$mri 					=   $nombredia.'mri';
		$mrf 					=   $nombredia.'mrf';						
		$hhorario 				=   'h'.$nombredia;
		$diafecha 				=   $nombredia.'d';
		$funcion 				= 	$this;

		return View::make('horario/ajax/listaasistenciadiaria',
						 [
							 'listaasistencia'   	=> $listaasistencia,
							 'titulo'   	  		=> $titulo,
							 'empresa'   	  		=> $empresa,
							 'fecha'				=> $fecha,	
							 'mi'					=> $mi,	
							 'mf'					=> $mf,
							 'mri'					=> $mri,
							 'mrf'					=> $mrf,
							 'horario'				=> $horario,
							 'hhorario'				=> $hhorario,
							 'diafecha'				=> $diafecha,
							 'funcion'				=> $funcion,						 							 							 							 						 					 
						 ]);
	}


	public function actionAjaxListaHorariosEmpresa(Request $request)
	{
		$idempresa 				=  	$request['idempresa'];
		$idempresa 				= 	$this->funciones->decodificarmaestra($idempresa);
		$listahorario           =   Horarioempresa::where('empresa_id','=',$idempresa)->get();
		
		return View::make('horario/ajax/listahorarioempresa',
						 [
							 'listahorario'   => $listahorario
						 ]);
	}


	public function actionAjaxListaHorariosEmpresaId(Request $request)
	{
		$idempresa 				=  	$request['idempresa'];
		$idempresa 				= 	$this->funciones->decodificarmaestra($idempresa);
		$listahorario           =   Horarioempresa::where('empresa_id','=',$idempresa)->get();
		
		return View::make('horario/ajax/listahorarioempresa',
						 [
							 'listahorario'   => $listahorario
						 ]);
	}


	public function actionHorarios($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $arrayempresa   = $this->funciones->arrayempresapermiso();

		$empresa 		= DB::table('empresas')->whereIn('id',$arrayempresa)->where('activo','=','0')->pluck('descripcion','id')->toArray();

		$comboempresa 	= $this->funciones->comboidencriptado($empresa,'Seleccione empresa');

		return View::make('horario/reporte/horarios',
						 [
						 	'idopcion' => $idopcion,
							'comboempresa' 	=> $comboempresa,
						 ]);
	}


	public function actionHorarioEmpresaPdf($idempresa)
	{
		set_time_limit(0);
		$idempresa 		= 	$this->funciones->decodificarmaestra($idempresa);
		$titulo			= 	"Horarios x Empresa";
		$listahorario   =   Horarioempresa::where('empresa_id','=',$idempresa)->get();
		$empresa   		=   Empresa::where('id','=',$idempresa)->first();

		$pdf 			= 	PDF::loadView('horario.pdf.horarioxempresa', 
											[ 
												'listahorario' 		  => $listahorario,
												'titulo' 		  	  => $titulo,
												'empresa' 		  	  => $empresa,
											]);


		return $pdf->stream('download.pdf');



	}


	public function actionHorarioSemanaPdf($idsemana)
	{


		set_time_limit(0);
		$horario 		= 	Horario::all()->toArray();
		$titulo			= 	"Horario x Semana";
		$idsemana 		= 	$this->funciones->decodificarmaestra($idsemana);
		$arraytrabajadores	=   $this->funciones->arraytrabajadorespermiso();
		$listahorario 	= 	Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)->where('semana_id','=',$idsemana)->get();

		$pdf 			= 	PDF::loadView('horario.pdf.horarioxsemana', 
											[ 
												'listahorario' 		  => $listahorario,
												'titulo' 		  	  => $titulo,
												'horario' 		  	  => $horario,												
											]);

		return $pdf->stream('download.pdf');



	}


}
