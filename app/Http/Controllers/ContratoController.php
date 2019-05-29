<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Trabajador, App\Contrato, App\Cargo, App\Tipocontrato,App\Jornadalaboral, App\Formato, App\Detallejornadalaboral;
use View;
use Session;
use Hashids;

class ContratoController extends Controller
{

	public function actionModificarContrato($idcontrato,$idopcion,$idtrabajador,Request $request)
	{



		/****************************** FECHA FIN CONTRATO ***********************/
			$fechafin = '';
			if($request['fechafin'] == null){
				$fechafin 	= '';
			}else{
				$fechafin  	= $request['fechafin'];
			}


			$cabecera            	 	 	=	Contrato::find($idcontrato);
			$cargo 							= 	Cargo::where('id','=',$request['cargo_id'])->first();
			$cabecera->fechainicio 			= 	$request['fechainicio'];
			$cabecera->fechafin 			= 	$fechafin;
			$cabecera->observacion 	 		=   $request['observacion'];
			$cabecera->estado 		 	 	= 	$request['estado'];
			$cabecera->gerencia_id 		 	= 	$cargo->unidad->area->gerencia->id;
			$cabecera->area_id 		 		= 	$cargo->unidad->area->id;
			$cabecera->unidad_id 		 	= 	$cargo->unidad->id;
			$cabecera->cargo_id 		 	= 	$cargo->id;
			$cabecera->tipocontrato_id 	 	= 	$request['tipocontrato_id'];
			$cabecera->tipopago_id 	 	 	= 	$request['tipopago_id'];
			$cabecera->formato_id 	 	 	= 	$request['formato_id'];
			$cabecera->numerocuenta  		=	$request['numerocuenta'];
			$cabecera->periodicidad_id   	= 	$request['periodicidad_id'];
			$cabecera->remuneracion  	 	=	$request['remuneracion'];

			$cabecera->IdUsuarioModifica 	= 	Session::get('usuario')->id;
			$cabecera->FechaModifica  		= 	$this->fechaActual;

			$cabecera->save();

			//////////////////////////////////// Llenamos Tabla DetalleJornadaLaborals ///////////////////

			$jornadalaborals 						= $request['jornadalaboral'];  
			$listajornadalaboral 					= Jornadalaboral::get(); 
			foreach($listajornadalaboral as $item){

				$activo 							= 0;
				if (in_array($item->id, $jornadalaborals)) {
				    $activo 						= 1;
				}

			    $detalle            				=	Detallejornadalaboral::where('contrato_id','=',$idcontrato)
			    										->where('jornadalaboral_id','=',$item->id)->first();			    
				$detalle->activo     				=  	$activo;
				$detalle->save();

			}

			
			////////////////////////////////////////////////////////////////////////

 			return Redirect::to('/ficha-contrato-trabajador/'.$idopcion.'/'.$idtrabajador)->with('bienhecho', 'Contrato'.$request['nombre'].' '.$request['apellidopaterno'].' Modificado con éxito');			
	}
	


	public function actionContrato($idopcion,$idtrabajador,Request $request)
	{
		/*****************************************************************/
		$idtrabajadorsd  = $idtrabajador;
	    $idtrabajador = $this->funciones->decodificar($idtrabajador);

		if($_POST)
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'id' => 'unique:contratos',
			], [
            	'id.unique' => 'Contrato ya registrado',
        	]);
			/******************************/
			$fechafin = '';
			if($request['fechafin'] == null){
				$fechafin 	= '';
			}else{
				$fechafin  	= $request['fechafin'];
			}

			$cargo 								 = Cargo::where('id','=',$request['cargo_id'])->first();
			$idcontrato 		 			 	 = $this->funciones->getCreateId('contratos');

			Contrato::where('trabajador_id','=', $idtrabajador)->update(['estado' => 0]);
			
			$cabecera            	 	 		 =	new Contrato;
			$cabecera->id 	     	 	 		 =  $idcontrato;
			$cabecera->trabajador_id  		 	 = 	$idtrabajador;
			$cabecera->fechainicio 				 = 	$request['fechainicio'];
			$cabecera->fechafin 				 = 	$fechafin;
			$cabecera->observacion 	 		 	 =  $request['observacion'];
			$cabecera->estado 		 	 		 = 	1;
			$cabecera->gerencia_id 		 		 = 	$cargo->unidad->area->gerencia->id;
			$cabecera->area_id 		 		 	 = 	$cargo->unidad->area->id;
			$cabecera->unidad_id 		 		 = 	$cargo->unidad->id;
			$cabecera->cargo_id 		 		 = 	$cargo->id;
			$cabecera->tipocontrato_id 	 		 = 	$request['tipocontrato_id'];
			$cabecera->tipopago_id 	 	 		 = 	$request['tipopago_id'];
			$cabecera->formato_id 	 	 		 = 	$request['formato_id'];
			$cabecera->local_id 				 = 	Session::get('local')->id; 

			$cabecera->IdUsuarioCrea 			 = 	Session::get('usuario')->id;
			$cabecera->FechaCrea  		         = 	$this->fechaActual;
			
			$cabecera->numerocuenta  			 =	$request['numerocuenta'];
			$cabecera->periodicidad_id   		 = 	$request['periodicidad_id'];
			$cabecera->remuneracion  	 		 =	$request['remuneracion'];
			$cabecera->save();

			//////////// Llenamos Tabla DetalleFichaCasaPartes ///////

			$jornadalaborals 						= $request['jornadalaboral']; // este es un array que nos devuelve todos los id seleccionados
			$listajornadalaboral 					= Jornadalaboral::get(); //listamos todos los casapartes
			foreach($listajornadalaboral as $item){

				// 
				$activo 							= 0;
				$iddetallejornadalaborals 			= $this->funciones->getCreateId('detallejornadalaborals');

				if (in_array($item->id, $jornadalaborals)) {
				    $activo 						= 1;
				}

			    $detalle            				=	new Detallejornadalaboral;
			    $detalle->id 	    				=  	$iddetallejornadalaborals;
				$detalle->contrato_id    			= 	$idcontrato;
				$detalle->jornadalaboral_id    		=  	$item->id;
				$detalle->local_id 					= 	Session::get('local')->id;
				$detalle->activo     				=  	$activo;
				$detalle->save();
			}


 			return Redirect::to('/ficha-contrato-trabajador/'.$idopcion.'/'.$idtrabajadorsd)->with('bienhecho', 'Contrato'.$request['nombre'].' '.$request['apellidopaterno'].' registrado con éxito');

		}else{


			$contrato 					 = Contrato::where('trabajador_id','=', $idtrabajador)
								  		   ->where('estado','=',1)->first();
			  		   

			$trabajador 				 = Trabajador::where('id', $idtrabajador)->first();

			$listacontrato 		    	 = Contrato::where('trabajador_id','=' , $idtrabajador)->get();

			if(count($contrato)>0){

				$jornadalaboral 		 = Detallejornadalaboral::join('jornadalaborals', 'detallejornadalaborals.jornadalaboral_id', '=', 'jornadalaborals.id')
											  		->select('jornadalaborals.id','jornadalaborals.descripcion','detallejornadalaborals.activo')
											  		->where('contrato_id','=',$contrato->id)->get();

				$tipocontrato 			 = DB::table('tipocontratos')->pluck('descripcion','id')->toArray();
				$combotipocontrato  	 = array($contrato->tipocontrato_id => $contrato->tipocontrato->descripcion) + $tipocontrato;

				$cargo 				 	 = DB::table('cargos')->pluck('nombre','id')->toArray();
				$combocargo  		 	 = array($contrato->cargo_id => $contrato->cargo->nombre) + $cargo;

				$jornadalaboral 		 = Detallejornadalaboral::join('jornadalaborals', 'DetallejornadaLaborals.jornadalaboral_id', '=', 'jornadalaborals.id')
												  ->select('jornadalaborals.id','jornadalaborals.descripcion','detallejornadalaborals.activo')
												  ->where('contrato_id','=',$contrato->id)->get();

				$periodicidad 			 = DB::table('periodicidads')->pluck('descripcion','id')->toArray();
				$comboperiodicidad  	 = array($contrato->periodicidad_id => $contrato->periodicidad->descripcion) + $periodicidad;

				$tipopago 				 = DB::table('tipopagos')->pluck('descripcion','id')->toArray();
				$combotipopago  		 = array($contrato->tipopago_id => $contrato->tipopago->descripcion) + $tipopago;

				$formato 				 = DB::table('formatos')->pluck('descripcionabreviada','id')->toArray();
				$comboformato 		 	 = array($contrato->formato_id => $contrato->formato->descripcion) + $formato;											  		

			}else{

				$jornadalaboral 		 = Jornadalaboral::get();

				$tipocontrato 		 	 = DB::table('tipocontratos')
								  		   ->where('activo','=',1)->pluck('descripcion','id')->toArray();

				$combotipocontrato  	 = array('' => "Seleccione Tipo Contrato") + $tipocontrato;

				$cargo					 = DB::table('cargos')->pluck('nombre','id')->toArray();
				$combocargo				 = array('' => "Seleccione Cargo") + $cargo;

				$tipopago				 = DB::table('tipopagos')->pluck('descripcion','id')->toArray();
				$combotipopago			 = array('' => "Seleccione Tipo Pago") + $tipopago;

				$formato				 = DB::table('formatos')->pluck('descripcionabreviada','id')->toArray();
				$comboformato			 = array('' => "Seleccione Formato") + $formato;
				
				$periodicidad			 = DB::table('periodicidads')->pluck('descripcion','id')->toArray();
				$comboperiodicidad		 = array('' => "Seleccione Periodicidad") + $periodicidad;				
			}

			//dd($trabajador);
	        return View::make('trabajador/contratotrabajador',
	        				[

	        					'listacontrato'  	    		=> $listacontrato,
	        					'trabajador'  	    			=> $trabajador,
	        					'idopcion'  	    			=> $idopcion,
	        					'combotipocontrato'  			=> $combotipocontrato,
	        					'combocargo'		    		=> $combocargo,
	        					'jornadalaboral'   				=> $jornadalaboral,
							  	'combotipopago' 				=> $combotipopago,		
							  	'comboformato' 					=> $comboformato,				
							  	'comboperiodicidad' 			=> $comboperiodicidad,
							  	'contrato' 						=> $contrato,
							  			
	        				]);
	        					
		}
	}

	public function actionContratoAjax(Request $request)
	{

		$id   							= $request['id'];
		$idopcion   					= $request['idopcion'];
		$idtrabajador   				= $request['idtrabajador'];


		$contrato 		    			= Contrato::where('id','=' , $id)->first();

		$tipocontrato 		 	 		= DB::table('tipocontratos')
								  		   ->where('activo','=',1)->pluck('descripcion','id')->toArray();
		$combotipocontrato  		 	= array($contrato->tipocontrato_id => $contrato->tipocontrato->descripcion) + $tipocontrato;

		$cargo 				 			= DB::table('cargos')->pluck('nombre','id')->toArray();
		$combocargo  		 			= array($contrato->cargo_id => $contrato->cargo->nombre) + $cargo;

		$jornadalaboral 				= Detallejornadalaboral::join('jornadalaborals', 'DetallejornadaLaborals.jornadalaboral_id', '=', 'jornadalaborals.id')
										  ->select('jornadalaborals.id','jornadalaborals.descripcion','detallejornadalaborals.activo')
										  ->where('contrato_id','=',$id)->get();

		$periodicidad 				 	= DB::table('periodicidads')->pluck('descripcion','id')->toArray();
		$comboperiodicidad  		 	= array($contrato->periodicidad_id => $contrato->periodicidad->descripcion) + $periodicidad;

		$tipopago 				 		= DB::table('tipopagos')->pluck('descripcion','id')->toArray();
		$combotipopago  		 		= array($contrato->tipopago_id => $contrato->tipopago->descripcion) + $tipopago;

		$formato 				 		= DB::table('formatos')->pluck('descripcionabreviada','id')->toArray();
		$comboformato 		 			= array($contrato->formato_id => $contrato->formato->descripcion) + $formato;



		return View::make('trabajador/ajax/editc',
						 [
	        				'id'  	    			=> $id,
	        				'idopcion'  	    	=> $idopcion,
	        				'idtrabajador'  	    => $idtrabajador,
	        				'combotipocontrato'  	=> $combotipocontrato, 
	        				'combocargo'  			=> $combocargo,
	        				'comboperiodicidad'  	=> $comboperiodicidad,
	        				'combotipopago'  		=> $combotipopago,
	        				'comboformato'  		=> $comboformato,
	        				'jornadalaboral'  	    => $jornadalaboral,
	        				'contrato'  	    	=> $contrato,
						 ]);
	}	

	public function actionContratoModalAjax(Request $request)
	{


		$idcontrato   				= $request['idcontrato'];
		$contrato 		    		= Contrato::where('id','=' , $idcontrato)->first();

		return View::make('contrato/ajax/modal',
						 [

	        				'contrato'  	    	=> $contrato,
						 ]);
	}	


}
