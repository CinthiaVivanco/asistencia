<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Trabajador,App\Estadocivil,App\Empresa,App\Local,App\Cargo,App\Horario,App\Paisemisordocumento,App\Contrato,App\Area;
use App\Detallejornadalaboral,App\Convenio,App\Situacioneducativa,App\Institucion,App\Carrera,App\Categoria,App\Ciudad,App\Maestro;
use View;
use ZipArchive;
use Session;
use Hashids;
use PDO;

class TrabajadorController extends Controller
{

	public function actionFichaTrabajador(Request $request){

		$id 						= strtoupper($request['id']);
		$trabajador     			= Trabajador::where('id', '=', $id)->first();
		$fichasocioeconomica     	= Fichasocioeconomica::where('id', '=', $id)->first();
		
		return View::make('usuario/ajax/datotrabajador',
						 [
						 	'trabajador' 			 => $trabajador,
						 	'fichasocioeconomica' 	 => $fichasocioeconomica
						 ]);
 	}

	public function actionListarTrabajador($idopcion)
	{


		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/ 

	    $arraylocales	   =   $this->funciones->arraylocalespermiso();

	    $listatrabajadores = Trabajador::whereIn('local_id',$arraylocales)->where('id','<>',$this->prefijomaestro.'000000000001')
									->where('activo','=',1)
							 		->orderBy('id', 'asc')
							 		->get();

		return View::make('trabajador/listatrabajadores',
						 [
						 	'listatrabajadores' => $listatrabajadores,
						 	'idopcion' => $idopcion,
						 ]);

	}


	public function actionAgregarTrabajador($idopcion,Request $request)
	{

		/********************** validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /*********************************************************/
	    
		if($_POST) 
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
				'dni' => Rule::unique('trabajadores')->where(function ($query) {
				    return $query->where('activo', 1);
				})
			], [
            	'dni.unique' => 'DNI ya registrado',
        	]);
			/******************************/

			$dni = $request['dni'];

			$idtrabajador 		 				 = $this->funciones->getCreateIdT('trabajadores');
			
			$cabecera            	 	 		 =	new Trabajador;
			$cabecera->id 	     	 	 		 =  $idtrabajador;
			$cabecera->tipodocumento_id  		 = 	$request['tipodocumento_id'];
			$cabecera->dni 	     		 		 =  $request['dni'];
			$cabecera->apellidopaterno 	 		 =  strtoupper($request['apellidopaterno']);
			$cabecera->apellidomaterno 	 		 = 	strtoupper($request['apellidomaterno']);
			$cabecera->nombres  		 		 =	strtoupper($request['nombre']);
			$cabecera->fechanacimiento 			 = 	$request['fechanacimiento'];
			$cabecera->fechaingreso 			 = 	$request['fechaingreso'];

			$cabecera->telefono  		 		 =	$request['telefono'];
			$cabecera->local_id 				 = 	$request['local_id'];
			$cabecera->IdUsuarioCrea 			 = 	Session::get('usuario')->id;
			$cabecera->FechaCrea 				 =  $this->fechaActual;

			$cabecera->template 		 		 = 	'';
			$cabecera->template10 			 	 = 	'';
			$cabecera->mar_huella 			 	 = 	'';
			$cabecera->mar_dni 				 	 = 	'';
			$cabecera->horario_id  				 = 	$request['horario_id'];
			$cabecera->area_id  				 = 	$request['area_id'];
			$cabecera->cargo_id  				 = 	$request['cargo_id'];
			$cabecera->save();

	    	//$this->funciones->guardarhuellaanterior($request['dni']);

			Maestro::where('codigoatributo','=','0003')->where('codigoestado','=','00001')->update(['codigo' => 'ACT']);

			$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC pasarhuella ?');
	        $stmt->bindParam(1, $dni ,PDO::PARAM_STR);
	        $stmt->execute();

 			return Redirect::to('/gestion-de-trabajador/'.$idopcion)->with('bienhecho', 'Trabajador '.$request['nombre'].' '.$request['apellidopaterno'].' registrado con éxito');

		}else{

			$tipodocumento 				 	= DB::table('tipodocumentos')
									  		->whereIn('id', [$this->prefijomaestro.'000000000001', $this->prefijomaestro.'000000000002',$this->prefijomaestro.'000000000004', $this->prefijomaestro.'000000000005'])
									  		->pluck('descripcion','id')
									  		->toArray();

			$combotipodocumento  		 	= array('' => "Seleccione Tipo Documento") + $tipodocumento;

		    $arrayempresa   				= $this->funciones->arrayempresapermiso();
			$empresa 						= DB::table('empresas')->whereIn('id',$arrayempresa)->pluck('descripcion','id')->toArray();

			$comboempresa  					= array('' => "Seleccione empresa") + $empresa;

			$combolocal			 			= array('' => "Seleccione Local");

			$comboarea		 		 	 	= array('' => "Seleccione Área");
			$combocargo		 		 	 	= array('' => "Seleccione Cargo"); 
		    $combohorario		 			= array('' => "Seleccione Horario");


		 //    $local 							= DB::table('locales')->where('activo','=','1')->pluck('nombreabreviado','id')->toArray();
			// $combolocal						= $local;

			$ffin 						 	= $this->fin;

			return View::make('trabajador/agregartrabajador',
						[
							'combotipodocumento' 			=> $combotipodocumento,
						  	'idopcion' 						=> $idopcion,
						  	'combohorario'   				=> $combohorario,
						  	'comboempresa' 					=> $comboempresa,
						  	'comboarea'	    				=> $comboarea,
						  	'combocargo'	    			=> $combocargo,
						  	'combolocal'   					=> $combolocal,
						  	'ffin'	  					    => $ffin,						
						]);

		}
	}

	public function actionModificarTrabajador($idopcion,$idtrabajador,Request $request)
	{

		/******************* validar url **********************/
		$validarurl   = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $idtrabajador = $this->funciones->decodificar($idtrabajador);
	    //$empresa 	  = $this->funciones->getEmpresa();
		
		if($_POST)  
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
				'dni' => Rule::unique('trabajadores')->where(function ($query) use($idtrabajador) {
				    return $query->where('activo', 1)
				    	   		 ->where('id','<>',$idtrabajador);
				})
			], [
            	'dni.unique' => 'DNI ya registrado',
        	]);

			$area_id 						  =  	$request['area_id'];

			/****************************** MODIFICAR TRABAJADOR ******************************/

			$cabecera            	 	 		  =		Trabajador::find($idtrabajador);


			$cabecera->apellidopaterno 	 		  =  	strtoupper($request['apellidopaterno']);
			$cabecera->apellidomaterno 	 		  = 	strtoupper($request['apellidomaterno']);
			$cabecera->nombres  		 		  =		strtoupper($request['nombre']);
			$cabecera->dni 	     		 		  =  	$request['dni'];
			$cabecera->fechanacimiento 			  = 	$request['fechanacimiento'];
			$cabecera->telefono  		 		  =		$request['telefono'];
			$cabecera->tipodocumento_id 	      =  	$request['tipodocumento_id'];
			$cabecera->area_id 	      			  =  	$area_id;
			$cabecera->local_id 	      		  =  	$request['local_id'];
			$cabecera->horario_id 		  		  = 	$request['horario_id'];
			$cabecera->cargo_id 		  		  = 	$request['cargo_id'];
			$cabecera->fechaingreso 			  = 	$request['fechaingreso'];
			
			$cabecera->IdUsuarioModifica 		  = 	Session::get('usuario')->id;
			$cabecera->FechaModifica 			  =     $this->fechaActual;
	
			$cabecera->save();

 			return Redirect::to('/gestion-de-trabajador/'.$idopcion)->with('bienhecho', 'Trabajador '.$request['nombre'].' '.$request['apellidopaterno'].' modificado con éxito');

		}else{

		        $trabajador 			= Trabajador::where('id', $idtrabajador)->first();

		        $tipodocumento 			= DB::table('tipodocumentos')
											  		->whereIn('id', [$this->prefijomaestro.'000000000001', $this->prefijomaestro.'000000000002',$this->prefijomaestro.'000000000004', $this->prefijomaestro.'000000000005'])
											  		->pluck('descripcion','id')
											  		->toArray();
				
		        $combotipodocumento  	= array($trabajador->tipodocumento_id => $trabajador->tipodocumento->descripcion,'' => "Seleccione Tipo Documento") + $tipodocumento;

		        /***************************************************************************************************/


		        $locales   = Local::where('empresa_id','=',$trabajador->local->empresa_id)->get();
			    $arrayarea=array(-1);
			    $i = 0;
				foreach($locales as $item){
					foreach($item->trabajador as $item2){
						$arrayarea[$i]=$item2->area_id;
						$i = $i+1;
					}
				}

				$area 					= DB::table('areas')->whereIn('id',$arrayarea)->pluck('nombre','id')->toArray();
				$comboarea  			= array($trabajador->area_id => $trabajador->area->nombre,'' => "Seleccione Área") + $area ;

				/***************************************************************************************************/

				$local 					= DB::table('locales')->pluck('nombreabreviado','id')->toArray();
				$combolocal  			= array($trabajador->local_id => $trabajador->local->nombreabreviado,'' => "Seleccione Local") + $local ;

				$horario 				= DB::table('horarios')->pluck('nombre','id')->toArray();
				$combohorario       	= array($trabajador->horario_id => $trabajador->horario ->nombre,'' => "Seleccione Horario") + $horario;

				$cargo 					= DB::table('cargos')->pluck('nombre','id')->toArray();
				$combocargo  			= array($trabajador->cargo_id => $trabajador->cargo->nombre,'' => "Seleccione Cargo") + $cargo ;

				$arrayempresa   		= $this->funciones->arrayempresapermiso();
				$empresa 				= DB::table('empresas')->whereIn('id',$arrayempresa)->pluck('descripcion','id')->toArray();
				$comboempresa  			= array($trabajador->local->empresa_id=> $trabajador->local->empresa->descripcion,'' => "Seleccione Empresa") + $empresa ;

				$ffin 					= $this->fin;

		        return View::make('trabajador/modificartrabajador', 
		        				[
														
		        					'trabajador'  	    			=> $trabajador,
		        					'idopcion'  	    			=> $idopcion,
		        					'combotipodocumento' 			=> $combotipodocumento,	
		        					'comboarea'						=> $comboarea,
		        					'combolocal'					=> $combolocal,
		        					'combocargo'					=> $combocargo,
						  			'combohorario' 				  	=> $combohorario,
						  			'comboempresa' 					=> $comboempresa,
						  			'ffin'	  					  	=> $ffin,
		        				]);

		       
		}
	}

	public function actionBajaTrabajador($idopcion,$idtrabajador,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idtrabajador = $this->funciones->decodificar($idtrabajador);

		if($_POST)
		{

			$cabecera            	 			  =	Trabajador::find($idtrabajador);			
			$cabecera->activo 	 	 			  = $request['activo'];	
			$cabecera->save();

			if($request['activo']==0){

				$trabajador = Trabajador::where('id', $idtrabajador)->first();

				$this->funciones->getquitarhorariotrabajadorbaja($this->fechaActual,$idtrabajador);
				Maestro::where('codigoatributo','=','0003')->where('codigoestado','=','00001')->update(['codigo' => 'ACT']);



			}


 			return Redirect::to('/gestion-de-trabajador/'.$idopcion)->with('bienhecho', 'Trabajador '.$request['nombre'].' '.$request['apellidopaterno'].' dado de BAJA');


		}else{

				$trabajador = Trabajador::where('id', $idtrabajador)->first();  

		        return View::make('trabajador/bajatrabajador', 
		        				[
		        					'trabajador'  => $trabajador,
						  			'idopcion' 	  => $idopcion
		        				]);
		}
	}
}
