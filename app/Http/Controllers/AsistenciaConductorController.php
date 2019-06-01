<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\PeriodoPiloto,App\ListaPiloto,App\PilotosAsistencia,App\ViajesPiloto,App\ViajesPilotoPacasmayo,App\ViajesCopilotoPacasmayo;
use View;
use Session;
use Hashids;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use TPDF;

class AsistenciaConductorController extends Controller
{

	public function actionAgregarAsistencia($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			// /**** Validaciones laravel ****/
			// $this->validate($request, [
	  //           'nombre' => 'unique:rols',
			// ], [
   //          	'nombre.unique' => 'Rol ya registrado',
   //      	]);
			// /******************************/

			// $idrol 					 = $this->funciones->getCreateIdMaestra('rols');

			// $cabecera            	 =	new Rol;
			// $cabecera->id 	     	 =  $idrol;
			// $cabecera->nombre 	     =  $request['nombre'];
			// $cabecera->save();

			// $listaopcion = Opcion::orderBy('id', 'asc')->get();
			// $count = 1;
			// foreach($listaopcion as $item){


			// 	$idrolopciones 		= $this->funciones->getCreateIdMaestra('rolopciones');


			//     $detalle            =	new RolOpcion;
			//     $detalle->id 	    =  	$idrolopciones;
			// 	$detalle->opcion_id = 	$item->id;
			// 	$detalle->rol_id    =  	$idrol;
			// 	$detalle->orden     =  	$count;
			// 	$detalle->ver       =  	0;
			// 	$detalle->anadir    =  	0;
			// 	$detalle->modificar =  	0;
			// 	$detalle->eliminar  =  	0;
			// 	$detalle->todas     = 	0;
			// 	$detalle->save();
			// 	$count 				= 	$count +1;
			// }

 			return Redirect::to('/gestion-de-conductores/'.$idopcion)->with('bienhecho', 'Asistencia del conductor '.$request['nombre'].' registrado con exito');
		}else{

		




			return View::make('conductores/agregarasistencia',
						[
						  	'idopcion' => $idopcion
						]);

		}
	}


	public function actionListarConductores($idopcion)
	{

				/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

         // $listapilotos      		= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdPiloto')  
         // 							->select('listapiloto.Id','listapiloto.NombreCompleto','listapiloto.NombreCargo','listapiloto.Dni')
         // 							->groupBy('listapiloto.Id')
         // 							->groupBy('listapiloto.NombreCompleto')
         // 							->groupBy('listapiloto.NombreCargo')
         // 							->groupBy('listapiloto.Dni')
         // 							->get();

         // $listacopiloto      	= 	PilotosAsistencia::join('listapiloto','listapiloto.Id','=','pilotosasistencia.IdCopiloto')  
         // 							->select('listapiloto.Id','listapiloto.NombreCompleto','listapiloto.NombreCargo','listapiloto.Dni')
         // 							->groupBy('listapiloto.Id')
         // 							->groupBy('listapiloto.NombreCompleto')
         // 							->groupBy('listapiloto.NombreCargo')
         // 							->groupBy('listapiloto.Dni')
         // 							->get();

		 //$listapiloto 			= 	$listapilotos->merge($listacopiloto);

		return View::make('conductores/listarconductores',
						 [
						 	//'listapiloto' => $listapiloto,
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
