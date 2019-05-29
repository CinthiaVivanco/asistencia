<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Semana,App\Trabajador,App\Horario,App\Horariotrabajador,App\Asistenciatrabajador;
use App\Horariotrabajadoresclonado,App\Descansovacacion,App\Asistenciadiaria;
use View;
use Session;
use Hashids;


class HorarioController extends Controller
{


	public function actionListarSemanasAsistencia($idopcion)
	{


		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	 
	    $listasemana 	= Semana::orderBy('numero', 'asc')->get();
	    $hoy 			= date_format(date_create($this->fin), 'Y-m-d');

		$comboarea  	= array('' => "Seleccione Area");

	    $arrayempresa   = $this->funciones->arrayempresapermiso();
		$empresa 		= DB::table('empresas')->whereIn('id',$arrayempresa)->pluck('descripcion','descripcion')->toArray();
		$comboempresa  	= array('' => "Seleccione empresa") + $empresa;

		$combosede		= $this->funciones->combopermisossedes();

		return View::make('horario/listasemanasasistencia',
						 [
						 	'listasemana' 	=> $listasemana,
						 	'idopcion' 		=> $idopcion,
						 	'comboarea' 	=> $comboarea,	
						 	'comboempresa' 	=> $comboempresa,
						 	'combosede' 	=> $combosede,						 								 						 	
						 	'hoy' 	   		=> $hoy,
						 ]);


	}


	public function actionAjaxListarHorarioAsistencia(Request $request)
	{


		$idsemana 				=  	$request['idsemana'];
		$idsede 				=  	$request['idsede'];
		$idsemana 				= 	$this->funciones->decodificarmaestra($idsemana);


	    $arraylocales   		= 	$this->funciones->arraylocalessedespermiso($idsede);
		$listatrabajadores 		= 	Trabajador::whereIn('local_id',$arraylocales)->where('id','<>',$this->prefijomaestro.'000000000001')
									->where('activo','=',1)
							 		->orderBy('id', 'asc')
							 		->get();

		$semana            		=   Semana::where('id','=',$idsemana)->first();
		$horario            	=   Horario::where('id','=',$this->prefijomaestro.'000000000001')->first();
		$fechainicio 			= 	$semana->fechainicio;
		$horariotrabajador 		= 	Horariotrabajador::where('semana_id','=',$idsemana)->first();
		$horario 				= 	DB::table('horarios')->pluck('nombre','id')->toArray();
		$combohorario  			= 	$horario;


		$arraytrabajadores		=   $this->funciones->arraytrabajadoressedespermiso($idsede);
		$listahorario 			= 	Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)->where('semana_id','=',$idsemana)->get();
		$funcion 				= 	$this;	



		return View::make('horario/ajax/listahorariopersonalasistencia',
						 [
							 'listahorario'   => $listahorario,
							 'combohorario'   => $combohorario,
						 	 'funcion' 	   	  => $funcion,							 
						 ]);

	}



	public function actionAjaxActualizarTablaAsistencia(Request $request)
	{


		$idasistencia 					= 	$request['idasistencia'];
		$dia 							= 	$request['dia'];
		$idasistenciatrabajadores 		= 	$this->funciones->decodificar($idasistencia);
		$asistenciatrabajador 			= 	Asistenciatrabajador::where('id','=',$idasistenciatrabajadores)->first();

		$funcion 						= 	$this;	
		$diah 							= 	$dia.'h';
		$hdia 							= 	'h'.$dia;
		$diad 							= 	$dia.'d';

		$diami 							= 	$dia.'mi';
		$diamri 						= 	$dia.'mri';		
		$diamrf 						= 	$dia.'mrf';	
		$diamf 							= 	$dia.'mf';
		$diacantmarc 					= 	$dia.'cantmarc';

		return View::make('horario/ajax/tablaasistencia',
						 [
						 	'asistenciatrabajador' 	=> $asistenciatrabajador,
						 	'diah' 					=> $diah,
						 	'hdia' 					=> $hdia,
						 	'dia' 					=> $dia,
						 	'diad' 					=> $diad,
						 	'diami' 				=> $diami,
						 	'diamri' 				=> $diamri,
						 	'diamrf' 				=> $diamrf,
						 	'diamf' 				=> $diamf,
						 	'diacantmarc' 			=> $diacantmarc,						 	
						 	'funcion' 				=> $funcion
						 ]);


	}


	public function actionAjaxModalAsistenciaTrabajador(Request $request)
	{


		$idasistencia 					= 	$request['idasistencia'];
		$idtrabajador 					= 	$request['idtrabajador'];
		$sectorupdate 					= 	$request['sectorupdate'];
		$dia 							= 	$request['dia'];
		$fecha 							= 	$request['fecha'];
		$idasistenciatrabajadores 		= 	$this->funciones->decodificar($idasistencia);
		$idtrabajador 					= 	$this->funciones->decodificar($idtrabajador);
		$asistenciatrabajador 			= 	Asistenciatrabajador::where('trabajador_id','=',$idtrabajador)
											->where('id','=',$idasistenciatrabajadores)->first();
		$funcion 						= 	$this;	
		$diah 							= 	$dia.'h';
		$hdia 							= 	'h'.$dia;
		$diad 							= 	$dia.'d';

		$diami 							= 	$dia.'mi';
		$diamri 						= 	$dia.'mri';		
		$diamrf 						= 	$dia.'mrf';	
		$diamf 							= 	$dia.'mf';
		$diacantmarc 					= 	$dia.'cantmarc';


		return View::make('horario/modal/asistencia',
						 [
						 	'asistenciatrabajador' 	=> $asistenciatrabajador,
						 	'diah' 					=> $diah,
						 	'hdia' 					=> $hdia,
						 	'dia' 					=> $dia,
						 	'diad' 					=> $diad,
						 	'diami' 				=> $diami,
						 	'diamri' 				=> $diamri,
						 	'diamrf' 				=> $diamrf,
						 	'diamf' 				=> $diamf,
						 	'sectorupdate' 			=> $sectorupdate,
						 	'diacantmarc' 			=> $diacantmarc,
						 	'funcion' 				=> $funcion
						 ]);


	}


	public function actionAjaxEliminarAsistenciaTrabajador(Request $request)
	{

		$hora 							= 	$request['hora'];
		$idasistencia 					= 	$request['idasistencia'];
		$idtrabajador 					= 	$request['idtrabajador'];
		$attractualizar 				= 	$request['attractualizar'];
		$dia 							= 	$request['dia'];
		$attrdiafecha 					= 	$request['attrdiafecha'];
		$fecha 							= 	$request['fecha'];
		$entrada 						= 	$request['entrada'];
		$cantmarc 						= 	$request['cantmarc'];
		$aviso 							= 	$request['aviso'];											
		$diacant 						= 	$dia.'cant';
		$attrhorario 					= 	$request['attrhorario'];
		$hora 							= 	'';

		$idasistenciatrabajadores 		= 	$this->funciones->decodificar($idasistencia);
		$idtrabajador 					= 	$this->funciones->decodificar($idtrabajador);

		$response 						= 	$this->funciones->getDiaSiguiente($idasistenciatrabajadores,$attrdiafecha);
		if($response[0]['error']){echo json_encode($response); exit();}

		$response 						= 	$this->funciones->getUltimaMarcacion($idasistenciatrabajadores,$dia,$cantmarc);
		if($response[0]['error']){echo json_encode($response); exit();}


		$cabecera            	 		=	Asistenciatrabajador::find($idasistenciatrabajadores);
		$cabecera->$attractualizar 		= 	$hora;					
		$cabecera->save();

		$diacant						= 	$dia.'cant';
		Asistenciatrabajador::where('id','=',$idasistenciatrabajadores)
								->update([$diacant => (int)$cantmarc-1]);

		Asistenciadiaria::where('trabajador_id','=',$idtrabajador)
							->where('asistenciatrabajadores_id','=',$idasistenciatrabajadores)
							->where('fecha','=',$fecha)
							->where('prefijoregistro',$attractualizar)
							->delete();


		echo json_encode($response);



	}


	public function actionAjaxActualizarAsistenciaTrabajador(Request $request)
	{


		$hora 							= 	$request['hora'];
		$idasistencia 					= 	$request['idasistencia'];
		$idtrabajador 					= 	$request['idtrabajador'];
		$attractualizar 				= 	$request['attractualizar'];
		$dia 							= 	$request['dia'];
		$attrdiafecha 					= 	$request['attrdiafecha'];
		$fecha 							= 	$request['fecha'];
		$entrada 						= 	$request['entrada'];
		$cantmarc 						= 	$request['cantmarc'];
		$aviso 							= 	$request['aviso'];											
		$diacant 						= 	$dia.'cant';
		$attrhorario 					= 	$request['attrhorario'];

		if($hora==Null){$hora = '';}

		$idasistenciatrabajadores 		= 	$this->funciones->decodificar($idasistencia);
		$idtrabajador 					= 	$this->funciones->decodificar($idtrabajador);

		$response 						= 	$this->funciones->getEntradavacio($entrada,$hora);
		if($response[0]['error']){echo json_encode($response); exit();}

		$response 						= 	$this->funciones->getDiaSiguiente($idasistenciatrabajadores,$attrdiafecha);
		if($response[0]['error']){echo json_encode($response); exit();}

		$response 						= 	$this->funciones->getMarcacionanterior($idasistenciatrabajadores,$dia,$cantmarc);
		if($response[0]['error']){echo json_encode($response); exit();}


		$asistenciadiaria 				= 	Asistenciadiaria::where('trabajador_id','=',$idtrabajador)
											->where('asistenciatrabajadores_id','=',$idasistenciatrabajadores)
											->where('fecha','=',$fecha)
											->where('prefijoregistro',$attractualizar)->first();


		$cabecera            	 		=	Asistenciatrabajador::find($idasistenciatrabajadores);
		$cabecera->$attractualizar 		= 	$hora;					
		$cabecera->save();


		if($hora==''){
			$hdia						= 	'h'.$dia;
			$asistencia 				=   Asistenciatrabajador::where('id','=', $idasistenciatrabajadores)
											->select($hdia)->first();
			$horario 					=  	Horario::where('id','=',$asistencia->$hdia)->select($attrhorario)->first();
			$hora 						=  	$horario->$attrhorario;
		}



		if(count($asistenciadiaria)){

			Asistenciadiaria::where('trabajador_id','=',$idtrabajador)
							->where('asistenciatrabajadores_id','=',$idasistenciatrabajadores)
							->where('fecha','=',$fecha)
							->where('prefijoregistro',$attractualizar)
							->update(['hora' => $hora , 'registro' => 'WB' , 'activo' => '1' ,
									  'usuariomodi_id' => Session::get('usuario')->id , 'fechamodi' => $this->fechaActual ]);

		}else{

			/******** actualizar la cantidad de marcaciones *********/
			$diacant					= 	$dia.'cant';
			$asistencia 				=   Asistenciatrabajador::where('id','=', $idasistenciatrabajadores)
											->select($diacant)->first();

			if((int)$cantmarc > $asistencia->$diacant){
				Asistenciatrabajador::where('id','=',$idasistenciatrabajadores)
										->update([$diacant => $cantmarc]);
			}


			/******** insertar una asistencia diaria ***********/

			$trabajador 						= 	Trabajador::where('id','=',$idtrabajador)->first();
			$asistenciatrabajador 				= 	Asistenciatrabajador::where('id','=',$idasistenciatrabajadores)->first();



			$time 								= strtotime($fecha.' '.$hora.':00');
			$fechatime 							= date('d-m-Y H:i:s',$time);

		    $cabecera            				=	new Asistenciadiaria;
		    $cabecera->trabajador_id 	    	=  	$idtrabajador;
			$cabecera->alias    				=  	$trabajador->nombres.' '.$trabajador->apellidopaterno.' '.$trabajador->apellidomaterno;
		    $cabecera->hora 					=  	$hora;
		    $cabecera->estadoaviso 				=  	$aviso; 		     
		    $cabecera->fecha 					=  	$fecha;
		    $cabecera->fechatime 				=  	$fechatime;
		    $cabecera->prefijo 					=  	$dia;
		    $cabecera->prefijoregistro 			=  	$attractualizar;
		    $cabecera->registro 				=  	'WB';
		    $cabecera->usuariocrea_id 			=  	Session::get('usuario')->id;
		    $cabecera->fechacrea 				=  	$this->fechaActual;
		    $cabecera->activo 					=  	1;
		    $cabecera->asistenciatrabajadores_id =  $idasistenciatrabajadores;		    
		    $cabecera->semana_id 				=  	$asistenciatrabajador->semana_id;			    
			$cabecera->save();

		}

		echo json_encode($response);

	}



	public function actionListarSemanas($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    
	 
	    $listasemana 			= 	Semana::orderBy('numero', 'asc')->get();
	    $hoy 					= 	date_format(date_create($this->fin), 'Y-m-d');
		$comboarea  			= 	array('' => "Seleccione Area");

		$combosede				= 	$this->funciones->combopermisossedes();

	    $arrayempresa   		= $this->funciones->arrayempresapermiso();	    
		$empresa 				= DB::table('empresas')->whereIn('id',$arrayempresa)->pluck('descripcion','descripcion')->toArray();
		$comboempresa  			= array('' => "Seleccione empresa") + $empresa;

		$combotrabajadores  	= array('' => "Seleccione trabajador");		

		return View::make('horario/listasemanas',
						 [
						 	'listasemana' 			=> $listasemana,
						 	'idopcion' 				=> $idopcion,
						 	'comboarea' 			=> $comboarea,	
						 	'comboempresa' 			=> $comboempresa,
						 	'combosede' 			=> $combosede,						 	
						 	'combotrabajadores' 	=> $combotrabajadores,						 								 						 	
						 	'hoy' 	   				=> $hoy,
						 ]);

	}

	public function actionAjaxAltaTrabajadorHorario(Request $request)
	{

		$trabajador_id 			=  	$request['trabajador_id'];
		$semana_id 				=  	$request['semana_id'];
		$trabajador_id 			= 	$this->funciones->decodificar($trabajador_id);
		$semana_id 				= 	$this->funciones->decodificarmaestra($semana_id);

		$semana            		=   Semana::where('id','=',$semana_id)->first();
		$fechainicio 			= 	$semana->fechainicio;
		$listatrabajadores 		= 	Trabajador::where('id','=',$trabajador_id)
							 		->get();

		foreach($listatrabajadores as $item){


			$idhorariotrabajador 		= 	$this->funciones->getCreateId('horariotrabajadores');
			$idasistenciatrabajadores 	= 	$this->funciones->getCreateId('asistenciatrabajadores');

		    $cabecera            		=	new Horariotrabajador;
		    $cabecera->id 	    		=  	$idhorariotrabajador;
			$cabecera->luh 				= 	1;
			$cabecera->lud    			=  	$fechainicio;
			$cabecera->hlu 				= 	$item->horario_id;
			$cabecera->rhlu 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;

			$cabecera->mah 				= 	1;
			$cabecera->mad    			=  	date('Y-m-d' ,strtotime('+1 day',strtotime($fechainicio)));
			$cabecera->hma 				= 	$item->horario_id;
			$cabecera->rhma 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;

			$cabecera->mih 				= 	1;
			$cabecera->mid    			=  	date('Y-m-d' ,strtotime('+2 day',strtotime($fechainicio)));
			$cabecera->hmi 				= 	$item->horario_id;
			$cabecera->rhmi 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;				

			$cabecera->juh 				= 	1;
			$cabecera->jud    			=  	date('Y-m-d' ,strtotime('+3 day',strtotime($fechainicio)));
			$cabecera->hju 				= 	$item->horario_id;
			$cabecera->rhju 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;					

			$cabecera->vih 				= 	1;
			$cabecera->vid    			=  	date('Y-m-d' ,strtotime('+4 day',strtotime($fechainicio)));
			$cabecera->hvi 				= 	$item->horario_id;
			$cabecera->rhvi 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;					

			$cabecera->sah 				= 	1;
			$cabecera->sad    			=  	date('Y-m-d' ,strtotime('+5 day',strtotime($fechainicio)));
			$cabecera->hsa 				= 	$item->horario_id;
			$cabecera->rhsa 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;				

			$cabecera->doh 				= 	1;
			$cabecera->dod    			=  	date('Y-m-d' ,strtotime('+6 day',strtotime($fechainicio)));
			$cabecera->hdo 				= 	$item->horario_id;
			$cabecera->rhdo 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;					

		    $cabecera->trabajador_id 	=  	$item->id;
		    $cabecera->semana_id 		=  	$semana_id;
		    $cabecera->local_id 		=  	Session::get('local')->id;		    
			$cabecera->save();


		    $cabecera            				=	new Asistenciatrabajador;
		    $cabecera->id 	    				=  	$idasistenciatrabajadores;

			$cabecera->lud    					=  	$fechainicio;
		    $cabecera->hlu 						=  	$item->horario_id; 
		    $cabecera->lucantmarc 				=  	$item->horario->marcacion;


			$cabecera->mad    					=  	date('Y-m-d' ,strtotime('+1 day',strtotime($fechainicio)));
		    $cabecera->hma 						=  	$item->horario_id;
		    $cabecera->macantmarc 				=  	$item->horario->marcacion;

			$cabecera->mid    					=  	date('Y-m-d' ,strtotime('+2 day',strtotime($fechainicio)));
		    $cabecera->hmi 						=  	$item->horario_id;
		    $cabecera->micantmarc 				=  	$item->horario->marcacion;

			$cabecera->jud    					=  	date('Y-m-d' ,strtotime('+3 day',strtotime($fechainicio)));
		    $cabecera->hju 						=  	$item->horario_id;
		    $cabecera->jucantmarc 				=  	$item->horario->marcacion;

			$cabecera->vid    					=  	date('Y-m-d' ,strtotime('+4 day',strtotime($fechainicio)));
		    $cabecera->hvi 						=  	$item->horario_id;
		    $cabecera->vicantmarc 				=  	$item->horario->marcacion;

			$cabecera->sad    					=  	date('Y-m-d' ,strtotime('+5 day',strtotime($fechainicio)));
		    $cabecera->hsa 						=  	$item->horario_id;
		    $cabecera->sacantmarc 				=  	$item->horario->marcacion;

			$cabecera->dod    					=  	date('Y-m-d' ,strtotime('+6 day',strtotime($fechainicio)));
		    $cabecera->hdo 						=  	$item->horario_id;
		    $cabecera->docantmarc 				=  	$item->horario->marcacion;		

		    $cabecera->trabajador_id 			=  	$item->id;
		    $cabecera->semana_id 				=  	$semana_id;
		    $cabecera->horariotrabajador_id 	=  	$idhorariotrabajador;
		    $cabecera->local_id 				=  	Session::get('local')->id;			    
			$cabecera->save();


		}
	}


	public function actionAjaxListarHorario(Request $request)
	{

		$idsemana 				=  	$request['idsemana'];
		$idsede 				=  	$request['idsede'];


		$idsemana 				= 	$this->funciones->decodificarmaestra($idsemana);

	    $arraylocales   		= 	$this->funciones->arraylocalessedespermiso($idsede);

		$listatrabajadores 		= 	Trabajador::whereIn('local_id',$arraylocales)->where('id','<>',$this->prefijomaestro.'000000000001')
									->where('activo','=',1)
							 		->orderBy('id', 'asc')
							 		->get();

		$semana            		=   Semana::where('id','=',$idsemana)->first();

		$horario            	=   Horario::where('id','=',$this->prefijomaestro.'000000000001')->first();
		$fechainicio 			= 	$semana->fechainicio;

		$arraytrabajadores		=   $this->funciones->arraytrabajadoressedespermiso($idsede);

		$horariotrabajador 		= 	Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)->where('semana_id','=',$idsemana)->first();
    
		if(count($horariotrabajador)<=0){

			foreach($listatrabajadores as $item){


				$idhorariotrabajador 		= 	$this->funciones->getCreateId('horariotrabajadores');
				$idasistenciatrabajadores 	= 	$this->funciones->getCreateId('asistenciatrabajadores');

			    $cabecera            		=	new Horariotrabajador;
			    $cabecera->id 	    		=  	$idhorariotrabajador;
				$cabecera->luh 				= 	1;
				$cabecera->lud    			=  	$fechainicio;
				$cabecera->hlu 				= 	$item->horario_id;
				$cabecera->rhlu 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;

				$cabecera->mah 				= 	1;
				$cabecera->mad    			=  	date('Y-m-d' ,strtotime('+1 day',strtotime($fechainicio)));
				$cabecera->hma 				= 	$item->horario_id;
				$cabecera->rhma 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;

				$cabecera->mih 				= 	1;
				$cabecera->mid    			=  	date('Y-m-d' ,strtotime('+2 day',strtotime($fechainicio)));
				$cabecera->hmi 				= 	$item->horario_id;
				$cabecera->rhmi 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;				

				$cabecera->juh 				= 	1;
				$cabecera->jud    			=  	date('Y-m-d' ,strtotime('+3 day',strtotime($fechainicio)));
				$cabecera->hju 				= 	$item->horario_id;
				$cabecera->rhju 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;					

				$cabecera->vih 				= 	1;
				$cabecera->vid    			=  	date('Y-m-d' ,strtotime('+4 day',strtotime($fechainicio)));
				$cabecera->hvi 				= 	$item->horario_id;
				$cabecera->rhvi 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;					

				$cabecera->sah 				= 	1;
				$cabecera->sad    			=  	date('Y-m-d' ,strtotime('+5 day',strtotime($fechainicio)));
				$cabecera->hsa 				= 	$item->horario_id;
				$cabecera->rhsa 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;				

				$cabecera->doh 				= 	1;
				$cabecera->dod    			=  	date('Y-m-d' ,strtotime('+6 day',strtotime($fechainicio)));
				$cabecera->hdo 				= 	$item->horario_id;
				$cabecera->rhdo 			= 	$item->horario->horainicio.' - '.$item->horario->horafin;					

			    $cabecera->trabajador_id 	=  	$item->id;
			    $cabecera->semana_id 		=  	$idsemana;
			    $cabecera->local_id 		=  	Session::get('local')->id;		    
				$cabecera->save();


			    $cabecera            				=	new Asistenciatrabajador;
			    $cabecera->id 	    				=  	$idasistenciatrabajadores;

				$cabecera->lud    					=  	$fechainicio;
			    $cabecera->hlu 						=  	$item->horario_id; 
			    $cabecera->lucantmarc 				=  	$item->horario->marcacion;


				$cabecera->mad    					=  	date('Y-m-d' ,strtotime('+1 day',strtotime($fechainicio)));
			    $cabecera->hma 						=  	$item->horario_id;
			    $cabecera->macantmarc 				=  	$item->horario->marcacion;

				$cabecera->mid    					=  	date('Y-m-d' ,strtotime('+2 day',strtotime($fechainicio)));
			    $cabecera->hmi 						=  	$item->horario_id;
			    $cabecera->micantmarc 				=  	$item->horario->marcacion;

				$cabecera->jud    					=  	date('Y-m-d' ,strtotime('+3 day',strtotime($fechainicio)));
			    $cabecera->hju 						=  	$item->horario_id;
			    $cabecera->jucantmarc 				=  	$item->horario->marcacion;

				$cabecera->vid    					=  	date('Y-m-d' ,strtotime('+4 day',strtotime($fechainicio)));
			    $cabecera->hvi 						=  	$item->horario_id;
			    $cabecera->vicantmarc 				=  	$item->horario->marcacion;

				$cabecera->sad    					=  	date('Y-m-d' ,strtotime('+5 day',strtotime($fechainicio)));
			    $cabecera->hsa 						=  	$item->horario_id;
			    $cabecera->sacantmarc 				=  	$item->horario->marcacion;

				$cabecera->dod    					=  	date('Y-m-d' ,strtotime('+6 day',strtotime($fechainicio)));
			    $cabecera->hdo 						=  	$item->horario_id;
			    $cabecera->docantmarc 				=  	$item->horario->marcacion;		

			    $cabecera->trabajador_id 			=  	$item->id;
			    $cabecera->semana_id 				=  	$idsemana;
			    $cabecera->horariotrabajador_id 	=  	$idhorariotrabajador;
			    $cabecera->local_id 				=  	Session::get('local')->id;			    
				$cabecera->save();


			}
		}


		$horario 		= DB::table('horarios')->pluck('nombre','id')->toArray();
		$combohorario  	= $horario;

		$listahorario 	= Horariotrabajador::where('semana_id','=',$idsemana)->whereIn('trabajador_id',$arraytrabajadores)->get();
		$funcion 		= $this;


		// sobrecargar nuevos
		$conforme = $this->funciones->cargar_trabajadores_nuevos($idsemana,$arraylocales,$fechainicio);

		return View::make('horario/ajax/listahorariopersonal',
						 [
							 'listahorario'   => $listahorario,
							 'combohorario'   => $combohorario,
							 'funcion'   	  => $funcion,
						 ]);

	}

	public function actionAjaxListarTrabajadoresHorario(Request $request)
	{

		$idsemana 			=  	$request['idsemana'];
		$idsede 			=  	$request['idsede'];


		$idsemana 			= 	$this->funciones->decodificarmaestra($idsemana);

	    $arraylocales   	= 	$this->funciones->arraylocalessedespermiso($idsede);

		$trabajadores 		=   Trabajador::leftJoin('horariotrabajadores', function($join) use ($idsemana)
							    {
							        $join->on('trabajadores.id', '=', 'horariotrabajadores.trabajador_id')
							        ->where('horariotrabajadores.semana_id', $idsemana);
							    })
								->select(DB::raw("trabajadores.id, trabajadores.apellidopaterno + ' ' + trabajadores.apellidomaterno + ' ' + trabajadores.nombres  as descripcion"))
								->whereNull('horariotrabajadores.trabajador_id')
								->where('trabajadores.activo','=',1)
								->whereIn('trabajadores.local_id',$arraylocales)
								->pluck('trabajadores.descripcion','trabajadores.id')
								->toArray();

		$combotrabajadores 	= 	$this->funciones->comboidencriptado($trabajadores,'Seleccione trabajador');



		return View::make('general/ajax/combotrabajadorhorario',
						 [
							 'combotrabajadores'   => $combotrabajadores,
							 'semana_id'		   => $idsemana
						 ]);


	}

	public function actionAjaxBajaTrabajadorHorario(Request $request)
	{

		$idhorariotrabajadores 			= 	$request['idhorario'];		
		$estado 						= 	$request['estado'];	
		$idhorariotrabajadores 			= 	$this->funciones->decodificar($idhorariotrabajadores);


		if($estado == 0){
			$response 						= 	$this->funciones->gettienehorariosemana($idhorariotrabajadores);
			if($response[0]['error']){echo json_encode($response); exit();}	
		}

		$response[] = array(
			'error'           		=> false,
			'mensaje'      			=> 'Realizado con exito',
		);	
		Horariotrabajador::where('id','=', $idhorariotrabajadores)->update(['activo' => $estado]);
		echo json_encode($response);

	}






	public function actionAjaxVacacionesDescansoHorarioTrabajador(Request $request)
	{


		$idhorariotrabajadores 			= 	$request['idhorario'];		
		$estado 						= 	$request['estado'];	
		$estado_btn 					= 	$request['estado_btn'];				
		$dia 							=  	$request['dia'];
		$fecha 							=  	$request['fecha'];		
		$diahorario						=  	$request['dia'].'d';
		$diacant 						= 	$request['dia'].'cant';	
		$atributo 						= 	$request['dia'].'h';
		$activo_btn 					= 	$request['activo_btn'];	


		$idhorariotrabajadores 			= 	$this->funciones->decodificar($idhorariotrabajadores);


		if($estado_btn == '0'){


			$response 					= 	$this->funciones->gettieneasistencia($idhorariotrabajadores,$diacant);
			if($response[0]['error']){echo json_encode($response); exit();}

			// quitamos check al horario
			Horariotrabajador::where('id','=', $idhorariotrabajadores)->update([$atributo => 0]);


			// agregamos a la tabla descanso y vacaciones 
			$horariotrabajador 						= Horariotrabajador::where('id','=', $idhorariotrabajadores)->first();
			$iddescanso 							= $this->funciones->getCreateId('descansovacaciones');


		    $cabecera            					=	new Descansovacacion;
		    $cabecera->id 	    					=  	$iddescanso;
			$cabecera->fecha    					=  	$fecha;
		    $cabecera->estado 						=  	$estado; 
		    $cabecera->usuariocrea_id 				=  	Session::get('usuario')->id;
			$cabecera->fechacrea    				=  	$this->fechaActual;
		    $cabecera->prefijo 						=  	$dia;
		    $cabecera->trabajador_id 				=  	$horariotrabajador->trabajador_id;
			$cabecera->horariotrabajador_id    		=  	$horariotrabajador->id;
		    $cabecera->semana_id 					=  	$horariotrabajador->semana_id;
		    $cabecera->local_id 					=  	Session::get('local')->id;	    
			$cabecera->save();


			echo json_encode($response);

		}else{



			// quitamos check al horario
			Horariotrabajador::where('id','=', $idhorariotrabajadores)->update([$atributo => 0]);

			// quitamos check al horario
			$descansovacaciones 					=   Descansovacacion::where('horariotrabajador_id','=', $idhorariotrabajadores)
														->where('fecha','=',$fecha)
														->first();

		    $descansovacaciones->usuariomodi_id 	=  	Session::get('usuario')->id;
			$descansovacaciones->fechamodi    		=  	$this->fechaActual;
		    $descansovacaciones->estado 			=  	$estado;
		    $descansovacaciones->activo 			=  	$activo_btn;		    
			$descansovacaciones->save();

			$exito[] = array(
				'error'           		=> false,
				'mensaje'      			=> 'Realizado con exito',
			);	

			echo json_encode($exito);

		}


		//echo json_encode($response);



	}

	public function actionAjaxActivarHorarioTrabajador(Request $request)
	{

		$prefijo 					= 	$request['dia'];
		$dia 						= 	$request['dia'].'d';
		$diacant 					= 	$request['dia'].'cant';
		$idhorariotrabajadores 		=  	$request['name'];

		$idhorariotrabajadores 		= 	$this->funciones->decodificar($idhorariotrabajadores);


		/*$response 					= 	$this->funciones->getDiaAnterior($idhorariotrabajadores,$dia);
		if($response[0]['error']){echo json_encode($response); exit();}*/

		$response 					= 	$this->funciones->gettieneasistencia($idhorariotrabajadores,$diacant);
		if($response[0]['error']){echo json_encode($response); exit();}

		$response 					= 	$this->funciones->gettienevacacionesodescanso($idhorariotrabajadores,$prefijo);
		if($response[0]['error']){echo json_encode($response); exit();}



		Horariotrabajador::where('id','=', $idhorariotrabajadores)->update([$request['accion'] => $request['check']]);

		echo json_encode($response);

	}





	public function actionAjaxSelectHorarioTrabajador(Request $request)
	{

		$idhorariotrabajadores 		=  	$request['idhorariotrabajador'];
		$idhorariotrabajadores 		= 	$this->funciones->decodificar($idhorariotrabajadores);
		$horario_id 				=  	$request['horario_id'];
		$hdia 						=  	'h'.$request['atributo']; //hlu.
		$rhdia 						=  	'rh'.$request['atributo']; //rhlu.
		$diacantmarc 				=  	$request['atributo'].'cantmarc'; //lucantmarc.
		$dia 						= 	$request['atributo'].'d';
		$diacant 					= 	$request['atributo'].'cant';

		$horario            		=   Horario::where('id','=',$horario_id)->first();
		$hora 						= 	$horario->horainicio.' - '.$horario->horafin;


		/*$response 					= 	$this->funciones->getDiaAnterior($idhorariotrabajadores,$dia);
		if($response[0]['error']){echo json_encode($response); exit();}*/

		$response 					= 	$this->funciones->gettieneasistencia($idhorariotrabajadores,$diacant);
		if($response[0]['error']){echo json_encode($response); exit();}



		Horariotrabajador::where('id','=', $idhorariotrabajadores)
						  	->update([
						  				$hdia 	=> $horario_id,
						  				$rhdia 	=> $hora
						  		  ]);

		Asistenciatrabajador::where('horariotrabajador_id','=', $idhorariotrabajadores)
							->update([
										$hdia => $horario_id,
										$diacantmarc => $horario->marcacion
									]);



		$exito[] = array(
			'error'           		=> false,
			'mensaje'      			=> 'Realizado con exito',
			'hora'      			=> $hora
		);	

		echo json_encode($exito);

	}


	public function actionAjaxClonarHorario(Request $request)
	{



		$idsemana 				=  	$request['idsemana'];
		$idsede 				=  	$request['idsede'];

		$idsemana 				= 	$this->funciones->decodificarmaestra($idsemana);		

		$arraytrabajadores		=   $this->funciones->arraytrabajadoressedespermiso($idsede);

		Horariotrabajadoresclonado::whereIn('trabajador_id',$arraytrabajadores)->where('activo','=','1')->delete();

		$horariotrabajador 		= 	Horariotrabajador::select('id','luh','lud','hlu','rhlu','mah','mad','hma','rhma',
											'mih','mid','hmi','rhmi','juh','jud','hju','rhju',
											'vih','vid','hvi','rhvi','sah','sad','hsa','rhsa',
											'doh','dod','hdo','rhdo','activo','trabajador_id','semana_id','local_id')
									->where('semana_id','=',$idsemana)
									->whereIn('trabajador_id',$arraytrabajadores)
									->get();

		foreach($horariotrabajador as $item){


			    $cabecera            		=	new Horariotrabajadoresclonado;
			    $cabecera->id 	    		=  	$item->id;
				$cabecera->luh 				= 	$item->luh;
				$cabecera->lud    			=  	$item->lud;
				$cabecera->hlu 				= 	$item->hlu;
				$cabecera->rhlu 			= 	$item->rhlu;

				$cabecera->mah 				= 	$item->mah;
				$cabecera->mad    			=  	$item->mad;
				$cabecera->hma 				= 	$item->hma;
				$cabecera->rhma 			= 	$item->rhma;

				$cabecera->mih 				= 	$item->mih;
				$cabecera->mid    			=  	$item->mid;
				$cabecera->hmi 				= 	$item->hmi;
				$cabecera->rhmi 			= 	$item->rhmi;				

				$cabecera->juh 				= 	$item->juh;
				$cabecera->jud    			=  	$item->jud;
				$cabecera->hju 				= 	$item->hju;
				$cabecera->rhju 			= 	$item->rhju;					

				$cabecera->vih 				= 	$item->vih;
				$cabecera->vid    			=  	$item->vid;
				$cabecera->hvi 				= 	$item->hvi;
				$cabecera->rhvi 			= 	$item->rhvi;					

				$cabecera->sah 				= 	$item->sah;
				$cabecera->sad    			=  	$item->sad;
				$cabecera->hsa 				= 	$item->hsa;
				$cabecera->rhsa 			= 	$item->rhsa;				

				$cabecera->doh 				= 	$item->doh;
				$cabecera->dod    			=  	$item->dod;
				$cabecera->hdo 				= 	$item->hdo;
				$cabecera->rhdo 			= 	$item->rhdo;					

			    $cabecera->activo 			=  	$item->activo;
			    $cabecera->trabajador_id 	=  	$item->trabajador_id;
			    $cabecera->semana_id 		=  	$item->semana_id;
			    $cabecera->local_id 		=  	$item->local_id;		    
				$cabecera->save();


		}

		//DB::table('horariotrabajadoresclonados')->insert($horariotrabajador);

		$response[] = array(
							'error'           		=> true
		);

		echo json_encode($response);

	}


	public function actionAjaxCopiarHorarioClonado(Request $request)
	{


		$idsemana 					=  	$request['idsemana'];
		$idsede 					=  	$request['idsede'];
		$idsemana 					= 	$this->funciones->decodificarmaestra($idsemana);		
		$arraytrabajadores			=   $this->funciones->arraytrabajadoressedespermiso($idsede);
		$listahorario 				= 	Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)->where('semana_id','=',$idsemana)->orderBy('id', 'asc')->get();


		/*$response 					= 	$this->funciones->getsemanatieneasistencia($idsemana);
		if($response[0]['error']){echo json_encode($response); exit();}*/


		foreach($listahorario as $item){


			$listahorarioclonado 		= 	Horariotrabajadoresclonado::where('trabajador_id','=', $item->trabajador_id)->first();


			if(count($listahorarioclonado)>0){


				/************** HORARIO DEL TRABAJADOR ******************/

				$cabecera            	 	=	Horariotrabajador::find($item->id);

				$cabecera->luh 				= 	$listahorarioclonado->luh;
				$cabecera->hlu 				= 	$listahorarioclonado->hlu;
				$cabecera->rhlu 			= 	$listahorarioclonado->rhlu;

				$cabecera->mah 				= 	$listahorarioclonado->mah;
				$cabecera->hma 				= 	$listahorarioclonado->hma;
				$cabecera->rhma 			= 	$listahorarioclonado->rhma;

				$cabecera->mih 				= 	$listahorarioclonado->mih;
				$cabecera->hmi 				= 	$listahorarioclonado->hmi;
				$cabecera->rhmi 			= 	$listahorarioclonado->rhmi;	

				$cabecera->juh 				= 	$listahorarioclonado->juh;
				$cabecera->hju 				= 	$listahorarioclonado->hju;
				$cabecera->rhju 			= 	$listahorarioclonado->rhju;					

				$cabecera->vih 				= 	$listahorarioclonado->vih;
				$cabecera->hvi 				= 	$listahorarioclonado->hvi;
				$cabecera->rhvi 			= 	$listahorarioclonado->rhvi;					

				$cabecera->sah 				= 	$listahorarioclonado->sah;
				$cabecera->hsa 				= 	$listahorarioclonado->hsa;
				$cabecera->rhsa 			= 	$listahorarioclonado->rhsa;

				$cabecera->doh 				= 	$listahorarioclonado->doh;
				$cabecera->hdo 				= 	$listahorarioclonado->hdo;
				$cabecera->rhdo 			= 	$listahorarioclonado->rhdo;	
				$cabecera->activo 			= 	$listahorarioclonado->activo;	

				$cabecera->save();



				/************** ASISTENCIA HORARIO DEL TRABAJADOR ******************/

				$cabeceras            		= 	Asistenciatrabajador::where('horariotrabajador_id', $item->id)->first();

				$horario            		=   Horario::where('id','=',$listahorarioclonado->hlu)->first();
			    $cabeceras->hlu 			=  	$horario->id; 
			    $cabeceras->lucantmarc 		=  	$horario->marcacion;

			    $horario            		=   Horario::where('id','=',$listahorarioclonado->hma)->first();
			    $cabeceras->hma 			=  	$horario->id;
			    $cabeceras->macantmarc 		=  	$horario->marcacion;

				$horario            		=   Horario::where('id','=',$listahorarioclonado->hmi)->first();
			    $cabeceras->hmi 			=  	$horario->id;
			    $cabeceras->micantmarc 		=  	$horario->marcacion;

				$horario            		=   Horario::where('id','=',$listahorarioclonado->hju)->first();
			    $cabeceras->hju 			=  	$horario->id;
			    $cabeceras->jucantmarc 		=  	$horario->marcacion;

				$horario            		=   Horario::where('id','=',$listahorarioclonado->hvi)->first();
			    $cabeceras->hvi 			=  	$horario->id;
			    $cabeceras->vicantmarc 		=  	$horario->marcacion;

				$horario            		=   Horario::where('id','=',$listahorarioclonado->hsa)->first();
			    $cabeceras->hsa 			=  	$horario->id;
			    $cabeceras->sacantmarc 		=  	$horario->marcacion;

				$horario            		=   Horario::where('id','=',$listahorarioclonado->hdo)->first();
			    $cabeceras->hdo 			=  	$horario->id;
			    $cabeceras->docantmarc 		=  	$horario->marcacion;	
				$cabeceras->save();	
			}



		}

		/************ dejar sin horario cuando es vacaciones o descanso ***************/
		$listadescansovaciones      =   Descansovacacion::where('activo','=','1')->where('semana_id','=',$idsemana)->get();

		foreach($listadescansovaciones as $deva){

			$diah						= 	$deva->prefijo.'h';
			Horariotrabajador::where('id','=',$deva->horariotrabajador_id)
									->update([$diah => 0]);
		}






		/*********** ACTUALIZAR EL AJAX DEL HORARIO ********/
		$horario 		= DB::table('horarios')->pluck('nombre','id')->toArray();
		$combohorario  	= $horario;

		$listahorario 	= Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)->where('semana_id','=',$idsemana)->get();
		$funcion 				= 	$this;		

		return View::make('horario/ajax/listahorariopersonal',
						 [
							 'listahorario'   => $listahorario,
							 'combohorario'   => $combohorario,
							 'funcion'		  => $funcion									 
						 ]);

	}









}
