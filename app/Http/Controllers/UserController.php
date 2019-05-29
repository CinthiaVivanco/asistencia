<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\User,App\Grupoopcion,App\Rol,App\RolOpcion,App\Opcion,App\Documento,App\Trabajador,App\Empresa,App\Local,App\Permisousersede;
use App\Permisouserempresa;
use View;
use Session;
use Hashids;


class UserController extends Controller
{

 	public function actionDatoTrabajador(Request $request){

		$dni 			= strtoupper($request['dni']);
		$trabajador     = Trabajador::where('dni', '=', $dni)->first();
		$usuario     	= User::where('dni', '=', $dni)->first();
		
		return View::make('usuario/ajax/datotrabajador',
						 [
						 	'trabajador' => $trabajador,
						 	'usuario' 	 => $usuario
						 ]);
 	}



	
   public function actionLogin(Request $request)
    {

		if($_POST)
		{
			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'name' => 'required',
	            'password' => 'required',

			], [
            	'name.required' => 'El campo Usuario es obligatorio',
            	'password.required' => 'El campo Clave es obligatorio',
        	]);

			/**********************************************************/
			

			$usuario 	 				 = strtoupper($request['name']);
			$clave   	 				 = strtoupper($request['password']);
			$local_id  	 				 = $request['local_id'];

			$tusuario    				 = User::whereRaw('UPPER(name)=?',[$usuario])->first();

			if(count($tusuario)>0)
			{
				$clavedesifrada 		 = 	strtoupper(Crypt::decrypt($tusuario->password));


				if($clavedesifrada == $clave)
				{
					$listamenu    		 = 	Grupoopcion::where('activo', '=', 1)->orderBy('orden', 'asc')->get();
					$local 				 = Local::where('id','=',$local_id)->first();

					
					Session::put('usuario', $tusuario);
					Session::put('local', $local); 
					Session::put('listamenu', $listamenu);

					return Redirect::to('bienvenido');
					
						
				}else{
					return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
				}	
			}else{
				return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
			}						    

		}else{

			$empresa 			= DB::table('empresas')->where('activo','=','1')->pluck('descripcion','id')->toArray();
			$comboempresa		= $empresa;
			$local 				= DB::table('locales')->where('activo','=','1')->pluck('nombreabreviado','id')->toArray();
			$combolocal			= $local;

			return view('usuario.login', 
						 [
						 	'comboempresa' => $comboempresa,
						 	'combolocal'   => $combolocal,
						 ]);
		}
    }

	public function actionBienvenido()
	{
		return View::make('bienvenido');
	}

	public function actionCerrarSesion()
	{

		Session::forget('usuario');
		Session::forget('listamenu');
		Session::forget('local');

		return Redirect::to('/login');
	}

	public function actionListarUsuarios($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');

	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $listausuarios = User::where('id','<>',$this->prefijomaestro.'000000000001')->orderBy('id', 'asc')->get();

		return View::make('usuario/listausuarios',
						 [
						 	'listausuarios' => $listausuarios,
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAgregarUsuario($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}

	    /******************************************************/

		if($_POST)
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'name' => 'unique:users',
	            'email' => 'unique:users'
			], [
            	'name.unique' => 'Usuario ya registrado',
            	'email.unique' => 'Correo Electronico ya registrado'
        	]);
			/******************************/
			$trabajador_id 	 		 	= 	$request['trabajador_id'];
			$trabajador     			=   Trabajador::where('id', '=', $trabajador_id)->first();

			$idusers 				 	=   $this->funciones->getCreateIdMaestra('users');
			
			$cabecera            	 	=	new User;
			$cabecera->id 	     	 	=   $idusers;
			$cabecera->nombre 	     	=   $trabajador->nombres;
			$cabecera->apellido 	 	=   $trabajador->apellidopaterno.' '.$trabajador->apellidomaterno;
			$cabecera->dni 	 		 	= 	$trabajador->dni;
			$cabecera->name  		 	=	$request['name'];
			$cabecera->email 	 	 	=  	$trabajador->email;
			$cabecera->password 	 	= 	Crypt::encrypt($request['password']);
			$cabecera->rol_id 	 		= 	$request['rol_id'];
			$cabecera->trabajador_id 	= 	$trabajador->id;
			$cabecera->save();
 


			//////////////////  Permisos  ///////////////////

			$permisos 	= $request['permisos'];

			foreach($permisos as $item=>$id)
			{

				$idpermisouserempresas 		=   $this->funciones->getCreateIdMaestra('permisouserempresas');
				
				$cabecera            	 	=	new Permisouserempresa;
				$cabecera->id 	     	 	=   $idpermisouserempresas;
				$cabecera->user_id 	     	=   $idusers;
				$cabecera->empresa_id 	 	=   $id;
				$cabecera->save();

			}

			//////////////////  sedes  ///////////////////

			$sedes 	= $request['sedes'];

			foreach($sedes as $item=>$id)
			{

				$permisousersedes 		=   $this->funciones->getCreateIdMaestra('permisousersedes');
				
				$cabecera            	 	=	new Permisousersede;
				$cabecera->id 	     	 	=   $permisousersedes;
				$cabecera->user_id 	     	=   $idusers;
				$cabecera->sede_id 	 	=   $id;
				$cabecera->save();

			}



 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$trabajador->nombres.' '.$trabajador->apellidopaterno.' '.$trabajador->apellidomaterno.' registrado con exito');

		}else{

		
			$rol 					= DB::table('Rols')->where('id','<>',$this->prefijomaestro.'000000000001')->pluck('nombre','id')->toArray();
			$comborol  				= array('' => "Seleccione Rol") + $rol;
			$empresas				= Empresa::get();
			$sedes					= $this->funciones->objetosedes();			

			return View::make('usuario/agregarusuario',
						[
							'comborol'  => $comborol,
							'empresas'  => $empresas,
							'sedes' 	=> $sedes,							
						  	'idopcion'  => $idopcion
						]);
		}
	}


	public function actionModificarUsuario($idopcion,$idusuario,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idusuario = $this->funciones->decodificarmaestra($idusuario);

		if($_POST)
		{
			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'name' => 'unique:users,name,'.$idusuario.',id'
			], [
            	'name.unique' => 'Usuario ya registrado',
            ]);	
			/******************************/


			$cabecera            	 =	User::find($idusuario);			
			$cabecera->name  		 =	$request['name'];
			$cabecera->password 	 = 	Crypt::encrypt($request['password']);
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->rol_id 	 	 = 	$request['rol_id']; 
			$cabecera->save();



			//////////////////  Permisos  ///////////////////

			$permisos 	= $request['permisos'];
			Permisouserempresa::where('user_id','=', $idusuario)->update(['activo' => 0]);
			$permisosempresa	= Permisouserempresa::where('user_id','=',$idusuario)->pluck('empresa_id')->toArray();

			foreach($permisos as $item=>$id)
			{

                if (in_array($id, $permisosempresa)) {

                	$userempresa			 =  Permisouserempresa::where('user_id','=',$idusuario)->where('empresa_id','=',$id)->first();
					$cabecera            	 =	Permisouserempresa::find($userempresa->id);			
					$cabecera->activo 	 	 =  1;			
					$cabecera->save();

                }else{

					$idpermisouserempresas 		=   $this->funciones->getCreateIdMaestra('permisouserempresas');
					$cabecera            	 	=	new Permisouserempresa;
					$cabecera->id 	     	 	=   $idpermisouserempresas;
					$cabecera->user_id 	     	=   $idusuario;
					$cabecera->empresa_id 	 	=   $id;
					$cabecera->save();	

                }
			}

			//////////////////  SEDES  ///////////////////

			$listasedes 	= $request['sedes'];
			Permisousersede::where('user_id','=', $idusuario)->update(['activo' => 0]);
			$sedes		= Permisousersede::where('user_id','=',$idusuario)->where('activo','=','1')->pluck('sede_id')->toArray();

			foreach($listasedes as $item=>$id)
			{

                if (in_array($id, $sedes)) {

                	$userempresa			 =  Permisousersede::where('user_id','=',$idusuario)->where('sede_id','=',$id)->first();
					$cabecera            	 =	Permisousersede::find($userempresa->id);			
					$cabecera->activo 	 	 =  1;			
					$cabecera->save();

                }else{

					$permisousersedes 			=   $this->funciones->getCreateIdMaestra('permisousersedes');
					
					$cabecera            	 	=	new Permisousersede;
					$cabecera->id 	     	 	=   $permisousersedes;
					$cabecera->user_id 	     	=   $idusuario;
					$cabecera->sede_id 	 		=   $id;
					$cabecera->save();

                }
			}



 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$request['nombre'].' '.$request['apellido'].' modificado con exito');


		}else{

			

				$usuario 	= User::where('id', $idusuario)->first();  
				$rol 		= DB::table('Rols')->where('id','<>',$this->prefijomaestro.'000000000001')->pluck('nombre','id')->toArray();
				$comborol  	= array($usuario->rol_id => $usuario->rol->nombre) + $rol;
				
				$empresas	= Empresa::get();
				$permisos	= Permisouserempresa::where('user_id','=',$idusuario)->where('activo','=','1')->pluck('empresa_id')->toArray();

				$listasedes	= $this->funciones->objetosedes();	
				$sedes		= Permisousersede::where('user_id','=',$idusuario)->where('activo','=','1')->pluck('sede_id')->toArray();




		        return View::make('usuario/modificarusuario', 
		        				[
		        					'usuario'  => $usuario,
									'comborol' => $comborol,
						  			'idopcion' => $idopcion,
						  			'empresas' => $empresas,
						  			'permisos' => $permisos,
						  			'listasedes' => $listasedes,
						  			'sedes' => $sedes						  			
		        				]);
		}
	}



	public function actionListarRoles($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaroles = Rol::where('id','<>',$this->prefijomaestro.'000000000001')->orderBy('id', 'asc')->get();

		return View::make('usuario/listaroles',
						 [
						 	'listaroles' => $listaroles,
						 	'idopcion' => $idopcion,
						 ]);

	}


	public function actionAgregarRol($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'nombre' => 'unique:rols',
			], [
            	'nombre.unique' => 'Rol ya registrado',
        	]);
			/******************************/

			$idrol 					 = $this->funciones->getCreateIdMaestra('rols');

			$cabecera            	 =	new Rol;
			$cabecera->id 	     	 =  $idrol;
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->save();

			$listaopcion = Opcion::orderBy('id', 'asc')->get();
			$count = 1;
			foreach($listaopcion as $item){


				$idrolopciones 		= $this->funciones->getCreateIdMaestra('rolopciones');


			    $detalle            =	new RolOpcion;
			    $detalle->id 	    =  	$idrolopciones;
				$detalle->opcion_id = 	$item->id;
				$detalle->rol_id    =  	$idrol;
				$detalle->orden     =  	$count;
				$detalle->ver       =  	0;
				$detalle->anadir    =  	0;
				$detalle->modificar =  	0;
				$detalle->eliminar  =  	0;
				$detalle->todas     = 	0;
				$detalle->save();
				$count 				= 	$count +1;
			}

 			return Redirect::to('/gestion-de-roles/'.$idopcion)->with('bienhecho', 'Rol '.$request['nombre'].' registrado con exito');
		}else{

		
			return View::make('usuario/agregarrol',
						[
						  	'idopcion' => $idopcion
						]);

		}
	}


	public function actionModificarRol($idopcion,$idrol,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $idrol = $this->funciones->decodificarmaestra($idrol);

		if($_POST)
		{
			//dd($idrol);

			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'nombre' => 'unique:rols,nombre,'.$idrol.',id',
			], [
            	'nombre.unique' => 'Rol ya registrado',
        	]);
			/******************************/

			$cabecera            	 =	Rol::find($idrol);
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-roles/'.$idopcion)->with('bienhecho', 'Rol '.$request['nombre'].' modificado con éxito');

		}else{
				$rol = Rol::where('id', $idrol)->first();

		        return View::make('usuario/modificarrol', 
		        				[
		        					'rol'  => $rol,
						  			'idopcion' => $idopcion
		        				]);
		}
	}
	

	public function actionListarPermisos($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaroles = Rol::where('id','<>',$this->prefijomaestro.'000000000001')->orderBy('id', 'asc')->get();

		return View::make('usuario/listapermisos',
						 [
						 	'listaroles' => $listaroles,
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAjaxListarOpciones(Request $request)
	{
		$idrol =  $request['idrol'];
		$idrol = $this->funciones->decodificarmaestra($idrol);

		$listaopciones = RolOpcion::where('rol_id','=',$idrol)->get();

		return View::make('usuario/ajax/listaopciones',
						 [
							 'listaopciones'   => $listaopciones
						 ]);
	}

	public function actionAjaxActivarPermisos(Request $request)
	{

		$idrolopcion =  $request['idrolopcion'];
		$idrolopcion = $this->funciones->decodificarmaestra($idrolopcion);

		$cabecera            	 =	RolOpcion::find($idrolopcion);
		$cabecera->ver 	     	 =  $request['ver'];
		$cabecera->anadir 	 	 =  $request['anadir'];	
		$cabecera->modificar 	 =  $request['modificar'];
		$cabecera->todas 	 	 =  $request['todas'];	
		$cabecera->save();

		echo("gmail");

	}




	public function pruebas()
	{

            $doc            	=   Documento::where('id', 11)->first();
            dd($doc->sunatdocumentoreferencia->nota_cre_deb);

		dd("hola");
		/*$listaopciones 	= RolOpcion::where('rol_id','=',2)->get();
		$listaopcion 	= Opcion::where('id','=',1)->first();
		foreach($listaopciones as $item){
			dd($item->opcion->grupoopcion->nombre);
		}*/
	}
}
