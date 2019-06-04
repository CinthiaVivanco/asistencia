<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\PeriodoPiloto,App\ListaPiloto,App\PilotosAsistencia,App\ViajesPiloto,App\ViajesPilotoPacasmayo,App\ViajesCopilotoPacasmayo;
use App\Piloto;
use View;
use Session;
use Hashids;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use TPDF;

class AsistenciaConductorController extends Controller
{



	public function actionModificarAsistenciaPiloto($idopcion,$idpiloto,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $idpiloto = $this->funciones->decodificarmaestra($idpiloto);

		if($_POST)
		{

			$fechaasistencia 			= 	$request['fechaasistencia'];
			$motivo 					= 	$request['motivo'];
			$activo 					= 	$request['activo'];	

			$asistenciapiloto           =   Piloto::where('id','=',$idpiloto)->first();
			$piloto						=	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdPiloto')  
				         					->select(DB::raw("listapiloto.Id, listapiloto.NombreCompleto"))
				         					->where('listapiloto.Id','=',$asistenciapiloto->idpiloto)
			         						->first();

			$cabecera            	 	=	Piloto::find($idpiloto);
			$cabecera->fechaviaje 	    = 	$fechaasistencia;
			$cabecera->motivo 	    	= 	$motivo;
			$cabecera->activo 	 	 	=  	$activo;			
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-conductores/'.$idopcion)->with('bienhecho', 'Asistencia del conductor '.$piloto->NombreCompleto.' modificado con éxito');

		}else{


				$piloto 	= Piloto::where('id', $idpiloto)->first();

		        return View::make('conductores/modificarasistencia', 
		        				[
		        					'piloto'  	=> $piloto,
						  			'idopcion' 	=> $idopcion
		        				]);

		}
	}



	public function actionAgregarAsistencia($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			$idpiloto 					= 	$request['pilotos'];
			$fechaasistencia 			= 	$request['fechaasistencia'];
			$motivo 					= 	$request['motivo'];

			$idpilotos 					= 	$this->funciones->getCreateIdMaestra('pilotos');

			$piloto						=	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdPiloto')  
				         					->select(DB::raw("listapiloto.Id, listapiloto.NombreCompleto"))
				         					->where('listapiloto.Id','=',$idpiloto)
			         						->first();

			$cabecera            	 	= 	new Piloto;
			$cabecera->id 	     	 	=  	$idpilotos;
			$cabecera->idpiloto	     	=  	$idpiloto;
			$cabecera->nombre 	     	= 	$piloto->NombreCompleto;
			$cabecera->fechaviaje 	    = 	$fechaasistencia;
			$cabecera->motivo 	    	= 	$motivo;
			$cabecera->save();

 			return Redirect::to('/gestion-de-conductores/'.$idopcion)->with('bienhecho', 'Asistencia del conductor '.$piloto->NombreCompleto.' registrado con exito');
		}else{

		
		 	$listapilotos      		= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdPiloto')  
	         							->select(DB::raw("listapiloto.Id, listapiloto.NombreCompleto"))
         								->groupBy('listapiloto.Id')
         								->groupBy('listapiloto.NombreCompleto')
         								->pluck('NombreCompleto','Id');

         	$listacopiloto      	= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdCopiloto')  
	         							->select(DB::raw("listapiloto.Id, listapiloto.NombreCompleto"))
	         							->groupBy('listapiloto.Id')
	         							->groupBy('listapiloto.NombreCompleto')
	         							->pluck('NombreCompleto','Id');


		 	$listapiloto 			= 	$listapilotos->merge($listacopiloto)->toArray();


			$combopilotos  			= 	array('' => "Seleccione piloto") + $listapiloto;
			$ffin 					= $this->fin;

			return View::make('conductores/agregarasistencia',
						[
						  	'idopcion' 			=> $idopcion,
						  	'combopilotos' 		=> $combopilotos,
						  	'ffin' 				=> $ffin,
						]);

		}
	}


	public function actionListarConductores($idopcion)
	{

				/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaasistencia 	= Piloto::get();

		return View::make('conductores/listarconductores',
						 [
						 	'listaasistencia' => $listaasistencia,
						 	'idopcion' 	  => $idopcion,
						 ]);
	}

	public function actionListadeconductoresjson()
	{

		 $listapilotos      	= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdPiloto')  
         							->select(DB::raw("listapiloto.Id as value, listapiloto.NombreCompleto  as text"))
         							->groupBy('listapiloto.Id')
         							->groupBy('listapiloto.NombreCompleto')
         							->get();

         $listacopiloto      	= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdCopiloto')  
         							->select(DB::raw("listapiloto.Id as value, listapiloto.NombreCompleto  as text"))
         							->groupBy('listapiloto.Id')
         							->groupBy('listapiloto.NombreCompleto')
         							->get();


		 $listapiloto 			= 	$listapilotos->merge($listacopiloto)->toArray();



		 return response()->json($listapiloto);
	}


	public function actionPilotoPeriodo($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/


		$comboperiodopiloto			= 	$this->funciones->combopilotoperiodo();
		$combosede 					= 	array('' => "Seleccione sede" , '0' => "Nacional", '1' => "Pacasmayo" );

		return View::make('horario/reporte/asistenciapiloto',
						 [
						 	'idopcion' 				=> $idopcion,
							'comboperiodopiloto' 	=> $comboperiodopiloto,
							'combosede' 			=> $combosede,
						 ]);

	}

	public function actionAsistenciaPeriodoExcel($idperiodo,$idsede)
	{
		set_time_limit(0);

		$periodo_id 			=  	$idperiodo;
		$tipo 					=  	$idsede;

		$titulo 				=   'ASISTENCIA PILOTO';

        $listapilotos      		= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdPiloto')  
        							->where('IdPlanillaPiloto','=',$periodo_id)
        							->where('Tipo','=',$tipo)
        							->select('listapiloto.Id','listapiloto.NombreCompleto','listapiloto.Dni')
        							->groupBy('listapiloto.Id')
        							->groupBy('listapiloto.NombreCompleto')
        							->groupBy('listapiloto.Dni')
        							->get();

        $listacopiloto      	= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdCopiloto')  
        							->where('IdPlanillaPiloto','=',$periodo_id)
        							->where('Tipo','=',$tipo)
        							->select('listapiloto.Id','listapiloto.NombreCompleto','listapiloto.Dni')
        							->groupBy('listapiloto.Id')
        							->groupBy('listapiloto.NombreCompleto')
        							->groupBy('listapiloto.Dni')
        							->get();

		$listapiloto 			= 	$listapilotos->merge($listacopiloto);




        $periodo      			= 	PeriodoPiloto::where('id','=',$periodo_id)->first();
		$funcion 				= 	$this;
		$fechainicio 			=  	date_format(date_create($periodo->fechainicio), 'Y-m-d');
		$fechafin 				=  	date_format(date_create($periodo->fechafin), 'Y-m-d');
		$listadias 				=   $this->funciones->dias_entre_dos_fechas($fechainicio,$fechafin);
		$idplanillapiloto       =   $periodo->id;


		if($tipo == 1){

	        $listaviajespi      	= 	ViajesPilotoPacasmayo::where('IdPlanillaPiloto','=',$periodo_id)
										->where('tipo','=',$tipo)
										->select(DB::raw('idpiloto+diaviaje as buscar'))
										->pluck('buscar')->toArray();

	        $listaviajesco      	= 	ViajesCopilotoPacasmayo::where('IdPlanillaPiloto','=',$periodo_id)
										->where('tipo','=',$tipo)
										->select(DB::raw('idpiloto+diaviaje as buscar'))
										->pluck('buscar')->toArray();

			$listaviajes			= 	array_merge($listaviajespi,$listaviajesco);

		}else{
	        $listaviajes      		= 	ViajesPiloto::where('IdPlanillaPiloto','=',$periodo_id)
										->where('tipo','=',$tipo)
										->select(DB::raw('idpiloto+diaviaje as buscar'))
										->pluck('buscar')->toArray();		
		}



	    Excel::create($titulo.' ('.$periodo->nombre.')', function($excel) use ($listapiloto,$funcion,$listadias,$idplanillapiloto,$listaviajes) {

	        $excel->sheet('Asistencias Piloto', function($sheet) use ($listapiloto,$funcion,$listadias,$idplanillapiloto,$listaviajes) {

	            $sheet->loadView('horario/excel/listaasistenciapiloto')->with('listapiloto',$listapiloto)
	            														->with('listadias',$listadias)
	            														->with('listaviajes',$listaviajes)
	            														->with('idplanillapiloto',$idplanillapiloto)
	                                         						   	->with('funcion',$funcion);	                                         		 
	        });
	    })->export('xls');

	}

}
