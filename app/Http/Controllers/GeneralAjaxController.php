<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Empresa,App\Local,App\Trabajador,App\Area,App\Horarioempresa,App\Horario,App\Cargoempresa;
use View;
use Session;
use Hashids;


class GeneralAjaxController extends Controller
{

	public function actionTrabajadorAreaEmpresaTodoAjax(Request $request)
	{


		$area_id   				= 	$request['area_id'];
		$empresa_id   			= 	$request['empresa_id'];
		$sede_id   				= 	$request['sede_id'];	

		if($area_id <> '1'){	$area_id 				= 	$this->funciones->decodificarmaestra($area_id);}
		$empresa_id 			= 	$this->funciones->decodificarmaestra($empresa_id);		

		$arrayareas				= 	DB::table('areas')->where('id','=',$area_id)->pluck('id')->toArray();

		if(count($arrayareas)>0 or $area_id =='1'){

			if($area_id == '1'){


				$tempresa  				= 	Empresa::where('id','=',$empresa_id)->first();
				$locales   				= 	Local::where('empresa_id','=',$tempresa->id)
											->where('identificador','=',$sede_id)->get();

			    $arrayarea=array(-1);
			    $i = 0;
				foreach($locales as $item){
					foreach($item->trabajador as $item2){
						$arrayarea[$i]=$item2->area_id;
						$i = $i+1;
					}
				}

				$arraytrabajadores 		=   $this->funciones->arraysedeempresatrabajadores($sede_id,$empresa_id);

				$trabajadores 		=   Trabajador::select(DB::raw("id, apellidopaterno + ' ' + apellidomaterno + ' ' + nombres  as descripcion"))
										//->where('activo','=',1)
										->whereIn('area_id',$arrayarea)
										->whereIn('id',$arraytrabajadores)										
										->pluck('descripcion','id')
										->toArray();

			}else{


				$arraytrabajadores 		=   $this->funciones->arraysedeempresatrabajadores($sede_id,$empresa_id);

				$trabajadores 		=   Trabajador::select(DB::raw("id, apellidopaterno + ' ' + apellidomaterno + ' ' + nombres  as descripcion"))
										//->where('activo','=',1)
										->whereIn('area_id',$arrayareas)
										->whereIn('id',$arraytrabajadores)
										->pluck('descripcion','id')
										->toArray();


			}

			$combotrabajador 	= 	$this->funciones->comboidencriptadotodos($trabajadores,'Seleccione trabajador');


		}else{
			$combotrabajador  	= array('' => "Seleccione trabajador");
		}


		return View::make('general/ajax/combotrabajadorareaempresafiltro',
						 [
						 'combotrabajador' => $combotrabajador
						 ]);
	}


	public function actionAreaEmpresaTodoAjax(Request $request)
	{

		$empresa   				= 	$request['empresa'];
		$sede_id   				= 	$request['sede_id'];		
		$empresa 				= 	$this->funciones->decodificarmaestra($empresa);
		$tempresa  				= 	Empresa::where('id','=',$empresa)->first();


		if(count($tempresa)>0){

			$locales   = Local::where('empresa_id','=',$tempresa->id)->where('identificador','=',$sede_id)->get();
		    $arrayarea=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayarea[$i]=$item2->area_id;
					$i = $i+1;
				}
			}

			$area 			= 	DB::table('areas')->whereIn('id',$arrayarea)->pluck('nombre','id')->toArray();

			$comboarea 		= 	$this->funciones->comboidencriptadotodos($area,'Seleccione Area');


		}else{
			$comboarea  	= array('' => "Seleccione Area");
		}


		return View::make('general/ajax/comboareaempresafiltro',
						 [
						 'comboarea' => $comboarea
						 ]);
	}


	public function actionSedeTrabajadoresTodoAjax(Request $request)
	{

		$sede_id   				= 	$request['sede_id'];

	    $arraylocales   		= 	$this->funciones->arraylocalessedespermiso($sede_id);
		$trabajadores 			=   Trabajador::select(DB::raw("id, apellidopaterno + ' ' + apellidomaterno + ' ' + nombres  as descripcion"))
									->where('activo','=',1)
									->whereIn('local_id',$arraylocales)
									->pluck('descripcion','id')
									->toArray();

		$combotrabajador 		= 	$this->funciones->comboidencriptadotodos($trabajadores,'Seleccione trabajador');

		return View::make('general/ajax/combosedetrabajadorfiltro',
						 [
						 'combotrabajador' => $combotrabajador
						 ]);
	}





	public function actionProvinciaAjax(Request $request)
	{
		$departamento_id   = $request['departamentos_id'];

		$provincia = DB::table('provincias')->where('departamento_id','=',$departamento_id)->pluck('nombre','id')->toArray();
		$comboprovincia  = array(0 => "Seleccione Provincia") + $provincia;

		return View::make('general/ajax/comboprovincia',
						 [
						 'comboprovincia' => $comboprovincia
						
						 ]);
	}	


	public function actionDistritoAjax(Request $request)
	{
		$provincia_id   = $request['provincia_id'];

		$distrito = DB::table('distritos')->where('provincia_id','=',$provincia_id)->pluck('nombre','id')->toArray();
		$combodistrito  = array(0 => "Seleccione Distrito") + $distrito;

		return View::make('general/ajax/combodistrito',
						 [
						 'combodistrito' => $combodistrito

						 ]);
	}	

	public function actionHorarioEmpresaIdAjax(Request $request)
	{

		$empresa   = $request['empresa'];
		$tempresa  = Empresa::where('id','=',$empresa)->first();

		if(count($tempresa)>0){
			$locales   = Local::where('empresa_id','=',$tempresa->id)->get();
		    $arrayhorario=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayhorario[$i]=$item2->horario_id;
					$i = $i+1;
				}
			}

			$horario 		= DB::table('horarios')->whereIn('id',$arrayhorario)->pluck('nombre','nombre')->toArray();
			$combohorario  	= array('' => "Seleccione horario") + $horario;

		}else{
			$combohorario  	= array('' => "Seleccione horario");
		}


		return View::make('general/ajax/combohorarioempresa',
						 [
						 'combohorario' => $combohorario
						 ]);
	}


	public function actionLocalEmpresaAjax(Request $request)
	{

		$empresa_id   = $request['empresa_id'];

		$local 		 = DB::table('locales')->where('empresa_id','=',$empresa_id)->pluck('nombreabreviado','id')->toArray();
		$combolocal  = array(0 => "Seleccione local") + $local;

		return View::make('general/ajax/combolocalempresa',
						 [
						 'combolocal' => $combolocal

						 ]);
	}

	public function actionAreaHorarioCargoEmpresaIdAjax(Request $request)
	{


		$empresa   	  = $request['empresa'];
		$tempresa  	  = Empresa::where('id','=',$empresa)->first();

		if(count($tempresa)>0){
			$locales   = Local::where('empresa_id','=',$tempresa->id)->get();
		    $arrayarea=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayarea[$i]=$item2->area_id;
					$i = $i+1;
				}
			}

			$area 			= DB::table('areas')->whereIn('id',$arrayarea)->pluck('nombre','id')->toArray();
			$comboarea  	= array('' => "Seleccione Area") + $area;

			$listahorario   = Horarioempresa::where('empresa_id','=',$empresa)->where('activo','=','1')->pluck('horario_id')->toArray();
			$horario 		= DB::table('horarios')->whereIn('id',$listahorario)->where('activo','=','1')->pluck('nombre','id')->toArray();
			$combohorario  	= array('' => "Seleccione Horario") + $horario;

			$listacargo   	= Cargoempresa::where('empresa_id','=',$empresa)->where('activo','=','1')->pluck('cargo_id')->toArray();
			$cargo			= DB::table('cargos')->whereIn('id',$listacargo)->where('activo','=','1')->pluck('nombre','id')->toArray();
			$combocargo  	= array('' => "Seleccione Cargo") + $cargo;



		}else{
			$comboarea  	= array('' => "Seleccione Area");
			$combohorario  	= array('' => "Seleccione Horario");
			$combocargo  	= array('' => "Seleccione Cargo");
		}


		return View::make('general/ajax/comboareahorariocargoempresa',
						 [
						 'comboarea' 		=> $comboarea,
						 'combohorario' 	=> $combohorario,
						 'combocargo' 		=> $combocargo,
						 ]);
	}


	public function actionAreaEmpresaAjax(Request $request)
	{


		$empresa   = $request['empresa'];
		$tempresa  = Empresa::where('descripcion','=',$empresa)->first();

		if(count($tempresa)>0){
			$locales   = Local::where('empresa_id','=',$tempresa->id)->get();
		    $arrayarea=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayarea[$i]=$item2->area_id;
					$i = $i+1;
				}
			}

			$area 			= DB::table('areas')->whereIn('id',$arrayarea)->pluck('nombre','nombre')->toArray();
			$comboarea  	= array('' => "Seleccione Area") + $area;

		}else{
			$comboarea  	= array('' => "Seleccione Area");
		}


		return View::make('general/ajax/comboareaempresa',
						 [
						 'comboarea' => $comboarea
						 ]);  
	}


	public function actionLocalAjax(Request $request)
	{

		$empresa_id   = $request['empresa_id'];

		$local 		 = DB::table('locales')->where('empresa_id','=',$empresa_id)->pluck('nombreabreviado','id')->toArray();
		$combolocal  = array(0 => "Seleccione local") + $local;

		return View::make('general/ajax/combolocal',
						 [
						 'combolocal' => $combolocal

						 ]);
	}

	public function actionAreaAjax(Request $request)
	{
		$gerencia_id   = $request['gerencia_id'];

		$area = DB::table('areas')->where('gerencia_id','=',$gerencia_id)->pluck('nombre','id')->toArray();
		$comboarea  = array(0 => "Seleccione Área") + $area;

		return View::make('general/ajax/comboarea',
						 [
						 'comboarea' => $comboarea
						
						 ]);
	}	


	public function actionUnidadAjax(Request $request)
	{
		$area_id   = $request['area_id'];

		$unidad = DB::table('unidades')->where('area_id','=',$area_id)->pluck('nombre','id')->toArray();
		$combounidad  = array(0 => "Seleccione Unidad") + $unidad;

		return View::make('general/ajax/combounidad',
						 [
						 'combounidad' => $combounidad
						
						 ]);
	}	

	public function actionCargoAjax(Request $request)
	{
		$unidad_id   = $request['unidad_id'];

		$cargo = DB::table('cargos')->where('unidad_id','=',$unidad_id)->pluck('nombre','id')->toArray();
		$combocargo  = array(0 => "Seleccione Cargo") + $cargo;

		return View::make('general/ajax/combocargo',
						 [
						 'combocargo' => $combocargo

						 ]);
	}



	public function actionTipoDocumentoAcreditaAjax(Request $request)
	{
		$vinculofamiliar_id   = $request['vinculofamiliar_id'];

		$tipodocumentoacredita = DB::table('tipodocumentoacreditas')->where('vinculofamiliar_id','=',$vinculofamiliar_id)->pluck('descripcionabreviado','id')->toArray();
		$combotipodocumentoacredita  = array(0 => "Seleccione Tipo Doc Acredita") + $tipodocumentoacredita;

		return View::make('general/ajax/combotipodocumentoacredita',
						 [
						 'combotipodocumentoacredita' => $combotipodocumentoacredita

						 ]);
	}		


	public function actionTipoInstitucionAjax(Request $request)
	{
		$regimeninstitucion_id   = $request['regimeninstitucion_id'];

		$tipoinstitucion = DB::table('tipoinstituciones')->where('regimeninstitucion_id','=',$regimeninstitucion_id)->pluck('nombre','id')->toArray();
		$combotipoinstitucion  = array('' => "Seleccione Tipo Institucion") + $tipoinstitucion;

		return View::make('general/ajax/combotipoinstitucion',
						 [
						 'combotipoinstitucion' => $combotipoinstitucion
						 ]);
	}	


	public function actionInstitucionAjax(Request $request)
	{
		
		$tipoinstitucion_id   = $request['tipoinstitucion_id'];

		$institucion = DB::table('instituciones')->where('tipoinstitucion_id','=',$tipoinstitucion_id)->pluck('nombre','id')->toArray();
		$comboinstitucion = array('' => "Seleccione Institucion") + $institucion;

		return View::make('general/ajax/comboinstitucion',
						 [
						 'comboinstitucion' => $comboinstitucion
						 ]);
	}


	public function actionCarreraAjax(Request $request)
	{
		$institucion_id = $request['institucion_id'];

		$carrera 		= DB::table('carreras')->where('institucion_id','=',$institucion_id)->pluck('nombre','id')->toArray();
		$combocarrera   = array('' => "Seleccione Carrera") + $carrera;

		return View::make('general/ajax/combocarrera',
						 [
						 'combocarrera' => $combocarrera
						 ]);
	}	
}
