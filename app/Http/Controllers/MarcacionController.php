<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Asistenciadiaria,App\Trabajador;
use View;
use Session;
use Hashids;
use PDO;


class MarcacionController extends Controller
{


	public function actionMarcacion()
	{

		$hoy 				= date_format(date_create($this->fin), 'Y-m-d');
        $localregistro_id 	= 'PRMAECEN000000000052';
		$asistenciadiaria =  Asistenciadiaria::where('fecha','=',$hoy)
							->whereIn('huella_dni', ['huella','dni'])
							->where('localregistro_id','=',$localregistro_id)
							->orderBy('fechatime', 'desc')
							->take(10)
							->get();

		return View::make('marcacion/marcacion',
						 [						 								 						 	
						 	'hoy' 	   					=> $hoy,
						 	'asistenciadiaria' 	   		=> $asistenciadiaria,						 	
						 ]);

	}

	public function actionMarcarAsistenciaAjax(Request $request)
	{

		$hoy 					= 	date_format(date_create($this->fin), 'Y-m-d');
		$dni 					=  	$request['dni'];
		$funcion 				= 	$this;	
		$hora 					= 	date("H:i:s");
		$localregistro_id 		= 	'PRMAECEN000000000052'; 

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC ValidarAsistencia ?,?');
        $stmt->bindParam(1, $dni ,PDO::PARAM_STR);
        $stmt->bindParam(2, $hora ,PDO::PARAM_STR);   
        $stmt->execute();
        $resultado = $stmt->fetch();

        if($resultado['error'] == '0'){

        	$idasistenca 		= $resultado['idasistencia']; 
        	$donderegistrar 	= $resultado['donderegistrar'];
        	$prefijo 			= $resultado['prefijo'];
        	$estadomensaje 	    = $resultado['estadomensaje'];
        	$huelladni 	    	= 'dni';
  

			$stmti = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC pr_iAsistencia ?,?,?,?,?,?,?');
	        $stmti->bindParam(1, $idasistenca ,PDO::PARAM_STR);
	        $stmti->bindParam(2, $donderegistrar ,PDO::PARAM_STR); 
	        $stmti->bindParam(3, $prefijo ,PDO::PARAM_STR);
	        $stmti->bindParam(4, $estadomensaje ,PDO::PARAM_STR); 
	        $stmti->bindParam(5, $hora ,PDO::PARAM_STR);
	        $stmti->bindParam(6, $huelladni ,PDO::PARAM_STR);
	        $stmti->bindParam(7, $localregistro_id ,PDO::PARAM_STR);	         	        	          
	        $stmti->execute();       

        }


		$asistenciadiaria =  Asistenciadiaria::where('fecha','=',$hoy)
							->whereIn('huella_dni', ['huella','dni'])
							->where('localregistro_id','=',$localregistro_id)
							->orderBy('fechatime', 'desc')
							->take(10)
							->get();

		$trabajador 	= Trabajador::where('dni','=',$dni)->first();
		$dnifoto        = '00000000';

		if(count($trabajador)>0){
			if(file_exists(public_path().'/img/fotos/'.$trabajador->dni.'.jpg' )){
				$dnifoto        = $trabajador->dni;
		  	} 
		}





		return View::make('marcacion/ajax/mensaje',
						 [
						 	 	'funcion' 	   	  			=> $funcion,
						 	 	'resultado' 	  			=> $resultado,
						 		'asistenciadiaria' 	   		=> $asistenciadiaria,
						 		'trabajador' 	   			=> $trabajador,	
						 		'dnifoto' 	   				=> $dnifoto,						 	 
						 ]);

	}




}
