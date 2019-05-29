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


class ReportePilotoController extends Controller
{


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
