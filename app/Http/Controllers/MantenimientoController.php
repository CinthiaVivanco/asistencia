<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Cargo,App\Cargoempresa,App\Empresa,App\Permisouserempresa;;
use View;
use ZipArchive;
use Session;
use Hashids;
use PDO;

class MantenimientoController extends Controller
{

	public function actionListarCargos($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $arrayempresas	   = $this->funciones->arrayempresaspermiso();
	   	$arraycargos	   = $this->funciones->arraycargosempresas($arrayempresas);

	    $listacargos 	   = Cargo::where('id','<>',$this->prefijomaestro.'000000000001')->whereIn('id',$arraycargos)->orderBy('id', 'asc')->get();

		return View::make('mantenimiento/listacargos',
						 [
						 	'listacargos' => $listacargos,
						 	'idopcion' 	  => $idopcion
						 ]);
	}

	public function actionAgregarCargo($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'nombre' => 'unique:cargos',
			], [
            	'nombre.unique' => 'Cargo ya registrado',
        	]);
			/******************************/

			//////////////////  Cargos  ///////////////////

					$idcargo 				 = $this->funciones->getCreateIdMaestra('cargos');

					$cabecera            	 =	new Cargo;
					$cabecera->id 	     	 =  $idcargo;
					$cabecera->nombre 	     =  $request['nombre'];
					$cabecera->save();


					//////////////////////////////////// Llenamos Tabla CargoEmpresas ///////////////////

					$permisos 						= $request['permisos'];  //1
					$empresas 						= Empresa::get();  //1,2,3,4
					foreach($empresas as $item){

						if (in_array($item->id, $permisos)) {

							$idcargoempresas 				 = $this->funciones->getCreateIdMaestra('cargoempresas');

							$detalle            	 =	new Cargoempresa;
							$detalle->id 	     	 =  $idcargoempresas;
							$detalle->cargo_id 	 	 =  $idcargo;
							$detalle->empresa_id 	 =  $item->id;
							$detalle->save();

						}
					}

					
					////////////////////////////////////////////////////////////////////////




 			return Redirect::to('/gestion-de-cargos/'.$idopcion)->with('bienhecho', 'Cargo '.$request['nombre'].' registrado con éxito');

		}else{

			$arrayempresas	   = $this->funciones->arrayempresaspermiso();
			$empresas		   = Empresa::whereIn('id',$arrayempresas)->get();

			return View::make('mantenimiento/agregarcargo',
						[
						  	'idopcion' 		 => $idopcion,
						  	'empresas'  	 => $empresas
						]);
		}
	}

	public function actionModificarCargo($idopcion,$idcargo,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $idcargo = $this->funciones->decodificarmaestra($idcargo);

		if($_POST)
		{
			//dd($idrol);

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'nombre' 		=> 'unique:cargos,nombre,'.$idcargo.',id',
			], [
            	'nombre.unique' => 'Cargo ya registrado',
        	]);
			/******************************/

			$cabecera            	 =	Cargo::find($idcargo);
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-cargos/'.$idopcion)->with('bienhecho', 'Cargo '.$request['nombre'].' modificado con éxito');

		}else{
				$cargo = Cargo::where('id', $idcargo)->first();

		        return View::make('mantenimiento/modificarcargo', 
		        				[
		        					'cargo'    => $cargo,
						  			'idopcion' => $idopcion
		        				]);
		}
	}
	
}
