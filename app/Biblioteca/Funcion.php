<?php
namespace App\Biblioteca;

use DB,Hashids,Session,Redirect,table;
use App\RolOpcion,App\Local,App\Empresa,App\Horariotrabajador,App\Semana,App\Permisouserempresa,App\Trabajador,App\Asistenciatrabajador,App\PeriodoPiloto;
use App\Descansovacacion,App\Horario,App\Permisousersede,App\ViajesPiloto;
use TPDF;
class Funcion{


	function asistencia_conductor($dia,$idpiloto,$idplanillapiloto,$listaviajes){

		$dia 	=  	date_format(date_create($dia), 'd/m/Y');
		/*$viaje 	= 	ViajesPiloto::where('IdPlanillaPiloto','=',$idplanillapiloto)
					->where('idpiloto','=',$idpiloto)
					->where('tipo','=',1)
					->where('diaviaje','=',$dia)->first();*/

		if( in_array($idpiloto.$dia, $listaviajes)){
			return true;
		}else{
			return false;
		}			

	}

	function dias_entre_dos_fechas($fechainicio,$fechafin){

	    $fecha1 = $fechainicio;
	    $fecha2 = $fechafin;
	    $dias=array();
	    for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
	    {
	    	array_push($dias,$i);
	    }
	   	return $dias;
	}



	function detallepdf($fecha,$item,$index,$horario,$rows){

		TPDF::SetFont('helvetica', 'n', 7);
		// Set MultiCell Defaults
		$width = '';// Set this per cell
		$height = '4';
		$text = '';//Set this per cell
		$border = '0';// 1/0 or L, T, R, B
		$align = 'L';// L, C, R, J
		$fill = '1'; //1/0
		$Ln = '0';// 0=right, 1 = beginning of next line, 2=below
		$floatX = '';
		$floatY = '';
		$resetH = 'true';

        $nombredia              =   $this->nombredia($fecha);
        $mi                     =   $nombredia.'mi';
        $mf                     =   $nombredia.'mf';
        $mri                    =   $nombredia.'mri';
        $mrf                    =   $nombredia.'mrf';
        $hhorario               =   'h'.$nombredia;
        $diafecha               =   $nombredia.'d';

        TPDF::Ln($height); // Establecer una nueva línea ANTES de cada datarow

		if ($rows%2==0){
		    TPDF::SetFillColor(245,245,245);
		}else{
		    TPDF::SetFillColor(255,255,255);
		}

		TPDF::MultiCell('15', $height, date_format(date_create($fecha), 'd-m-Y'), $border,'C', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('63', $height, $item->trabajador->apellidopaterno .' '. $item->trabajador->apellidomaterno .' '. $item->trabajador->nombres, $border, 'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('39', $height, substr($item->trabajador->area->nombre, 0, 25), $border, 'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('13', $height, $item->trabajador->dni, $border, 'C', $fill, $Ln, $floatX, $floatY, true);


        $key              =   array_search($item->asistenciatrabajador->$hhorario, array_column($horario, 'id'));
        $horainicio       =   $horario[$key]['horainicio'];
        $horafin          =   $horario[$key]['horafin'];
        $refrigerioinicio =   $horario[$key]['refrigerioinicio'];
        $refrigeriofin    =   $horario[$key]['refrigeriofin'];
        $marcacion        =   $horario[$key]['marcacion'];
        $vacadesc         =   $this->stringvacacionesdescanso($item->id,$item->$diafecha);

        if($vacadesc <> ''){
        				//TPDF::SetFillColor(234,67,53);
						TPDF::MultiCell('15', $height, $vacadesc, $border,'C', $fill, $Ln, $floatX, $floatY, true);
						TPDF::MultiCell('15', $height, $vacadesc, $border, 'C', $fill, $Ln, $floatX, $floatY, true);
						TPDF::MultiCell('15', $height, $vacadesc, $border, 'C', $fill, $Ln, $floatX, $floatY, true);
						TPDF::MultiCell('15', $height, $vacadesc, $border, 'C', $fill, $Ln, $floatX, $floatY, true);         	
        }else{

            if($item->asistenciatrabajador->$mi <> ''){
              if($this->restarminutos($horainicio,5) > $item->asistenciatrabajador->$mi){
              	TPDF::MultiCell('15', $height, $horainicio, $border,'C', $fill, $Ln, $floatX, $floatY, true);
              }else{
              	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mi, $border,'C', $fill, $Ln, $floatX, $floatY, true);
              } 
            }else{
            	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mi, $border,'C', $fill, $Ln, $floatX, $floatY, true);
            }

			

            if($item->asistenciatrabajador->$mri <> ''){
              if ($marcacion>2){
                if ($item->asistenciatrabajador->$mri > $this->sumarminutos($refrigerioinicio,8)){
                	TPDF::MultiCell('15', $height, $refrigerioinicio, $border,'C', $fill, $Ln, $floatX, $floatY, true);
                }else{
                	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mri, $border,'C', $fill, $Ln, $floatX, $floatY, true);
                }
              }else{
              	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mri, $border,'C', $fill, $Ln, $floatX, $floatY, true);
              }                   
            }else{
            	TPDF::MultiCell('15', $height, $this->refrigeriosalidamintra($fecha,$item->asistenciatrabajador->$hhorario,'refrigerioinicio',$item->asistenciatrabajador->$mi), $border,'C', $fill, $Ln, $floatX, $floatY, true);
            }


            if($item->asistenciatrabajador->$mrf <> ''){
              if ($marcacion>2){
                if ($this->restarminutos($refrigeriofin,8) > $item->asistenciatrabajador->$mrf){
                	TPDF::MultiCell('15', $height, $refrigeriofin, $border,'C', $fill, $Ln, $floatX, $floatY, true);
                }else{
                	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mrf, $border,'C', $fill, $Ln, $floatX, $floatY, true);
                }
              }else{
              	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mrf, $border,'C', $fill, $Ln, $floatX, $floatY, true);
              }                   
            }else{
            	TPDF::MultiCell('15', $height, $this->refrigeriosalidamintra($fecha,$item->asistenciatrabajador->$hhorario,'refrigeriofin',$item->asistenciatrabajador->$mi), $border,'C', $fill, $Ln, $floatX, $floatY, true);
            }

            if($item->asistenciatrabajador->$mf <> ''){
              if($this->horariofull($item->asistenciatrabajador->$hhorario)) {
              	  TPDF::MultiCell('15', $height, $this->salidamintra($fecha,$item->asistenciatrabajador->$hhorario,'horafin',$item->asistenciatrabajador->$mi,5), $border,'C', $fill, $Ln, $floatX, $floatY, true);
              }else{
                if ($item->asistenciatrabajador->$mf > $this->sumarminutos($horafin,15)) {
                	TPDF::MultiCell('15', $height, $horafin, $border,'C', $fill, $Ln, $floatX, $floatY, true);
                }else{
                	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mf, $border,'C', $fill, $Ln, $floatX, $floatY, true);
                }
              }
            }else{
            	TPDF::MultiCell('15', $height, $item->asistenciatrabajador->$mf, $border,'C', $fill, $Ln, $floatX, $floatY, true);
            }


        }


	}

	function emcabezadopdfdetalle($rows,$cantidad){

        if ($rows == $cantidad) // Establecer el número máximo de datarows por página
        {
                
			TPDF::AddPage();
			TPDF::SetFont('helvetica', 'n', 10);
			return 0;
		}
		return $rows;
	}




	function emcabezadopdf($empresa,$fechainicio,$fechafin){


		// Set MultiCell Defaults
		$width = '';// Set this per cell
		$height = '5';
		$text = '';//Set this per cell
		$border = '0';// 1/0 or L, T, R, B
		$align = 'L';// L, C, R, J
		$fill = '1'; //1/0
		$Ln = '0';// 0=right, 1 = beginning of next line, 2=below
		$floatX = '';
		$floatY = '';
		$resetH = 'true';
                
		TPDF::AddPage();


		TPDF::SetFont('helvetica', 'B', 10);
		TPDF::SetFillColor(255,255,255);
		TPDF::MultiCell('190', $height, 'REPORTE ASISTENCIA', $border,'C', $fill, $Ln, $floatX, $floatY, true);
		TPDF::Ln(10);
		TPDF::MultiCell('100', $height, $empresa->descripcion, $border,'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::SetFillColor(255,255,255);
		TPDF::MultiCell('90', $height, 'FECHA : '.date_format(date_create($fechainicio), 'd-m-Y').' / '.date_format(date_create($fechafin), 'd-m-Y'), $border,'R', $fill, $Ln, $floatX, $floatY, true);
		TPDF::Ln(7);
		TPDF::SetFillColor(255,255,255);
		TPDF::MultiCell('190', $height, 'RUC: '.$empresa->ruc, $border,'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::Ln(7);
		TPDF::SetFillColor(255,255,255);
		TPDF::MultiCell('190', $height, 'DOMICILIO: '.$empresa->domiciliofiscal1, $border,'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::Ln(10);
		TPDF::SetFont('helvetica', 'n', 10);


		TPDF::SetFillColor(187,233,255);
		TPDF::MultiCell('130', $height, 'DATOS PERSONALES', $border,'C', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('60', $height, 'ASISTENCIA', $border,'C', $fill, $Ln, $floatX, $floatY, true);
		TPDF::Ln(5);

		TPDF::SetFillColor(225,245,255);					
		TPDF::MultiCell('15', $height, 'FECHA', $border,'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('63', $height, 'APELLIDOS Y NOMBRES', $border, 'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('39', $height, 'ÁREA', $border, 'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('13', $height, 'DNI', $border, 'L', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('15', $height, 'Ent.', $border,'C', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('15', $height, 'Sal R.', $border, 'C', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('15', $height, 'Ent R.', $border, 'C', $fill, $Ln, $floatX, $floatY, true);
		TPDF::MultiCell('15', $height, 'Sal.', $border, 'C', $fill, $Ln, $floatX, $floatY, true);


 
	}


	function reportemintra($trabajador_id,$arraysemanas){


     	$listaasistencia        =   Horariotrabajador::where('trabajador_id','=',$trabajador_id)
				                    ->whereIn('semana_id',$arraysemanas)
				                    ->where('activo','=','1')			               
				                    ->orderBy('semana_id', 'asc')
				                    ->get(); 

        return $listaasistencia;
	}

	public function horariofull($idhorario) {

		$horario 				=   Horario::where('id','=', $idhorario)
									->where('horariofull','=',1)
									->first();							

		if(count($horario)>0){
			return true;
		}				

		return false;

	}


	public function salidamintra($fecha,$idhorario,$atributo,$horaentrada,$randon) {

		$hora = '';

		$minutos    			=   rand(0, $randon);
		$horario 				=   Horario::where('id','=', $idhorario)
									->first();							

		$horasalida = '07:00';		
		if($horario->horainicio == '07:00'){
			$horasalida = '19:00';
		}

		/******** validar antes del horario  *****/
		if(date("d-m-Y") == $fecha){
			if(date("H:i") <= $horasalida){
				return $hora;
			}
		}

	    $carbon = new \Carbon\Carbon();
	    $fecha = $carbon::createFromFormat('Y-m-d H:i:s', '2000-01-01 '.$horasalida.':00')->addMinute($minutos)->toDateTimeString();
	    $hora = substr($fecha, 11, 5);	
			

		return $hora;

	}


	public function refrigeriosalidamintra($fecha,$idhorario,$atributo,$horaentrada) {


		$hora = '';
		if($horaentrada == ''){
			return $hora;
		}

		$minutos    			=   rand(0, 5);
		$horario 				=   Horario::where('id','=', $idhorario)
									->select($atributo)
									->first();	

		/******** validar antes del horario  *****/
		if(date("d-m-Y") ==  date_format(date_create($fecha), 'd-m-Y')){
			if(date("H:i") <= $horario->$atributo){
				return $hora;
			}
		}

		if($horario->$atributo <> ''){
		    $carbon = new \Carbon\Carbon();
		    $fecha = $carbon::createFromFormat('Y-m-d H:i:s', '2000-01-01 '.$horario->$atributo.':00')->addMinute($minutos)->toDateTimeString();
		    $hora = substr($fecha, 11, 5);	
		}	

		if($horaentrada > $hora){
			return '';
		}

		return $hora;

	}


	public function combopermisossedes() {

		$arraysedespermisos   	=	Permisousersede::where('activo','=',1)
									->where('user_id','=',Session::get('usuario')->id)
									->pluck('sede_id')->toArray();

		$sedes  				=	Local::whereIn('identificador',$arraysedespermisos)
									->select('identificador as id', DB::raw('MAX(nombre) as nombre'))
									->where('identificador','<','50')
									->groupBy(DB::raw('identificador'))
									->orderBy(DB::raw('MAX(nombre)'), 'asc')
									->pluck('nombre','id')->toArray();

		$combosede  			= 	array('' => "Seleccione sede") + $sedes;

		return $combosede;


	}

	public function combopilotoperiodo() {

		$periodopiloto  				=	PeriodoPiloto::orderBy('fechainicio', 'desc')
											->pluck('nombre','id')->toArray();

		$comboperiodopiloto  			= 	array('' => "Seleccione periodo") + $periodopiloto;

		return $comboperiodopiloto;

	}



	public function objetosedes() {

		$arraysedespermisos   	=	Permisousersede::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('sede_id')->toArray();

		$sedes  				=	Local::select('identificador as id', DB::raw('MAX(nombre) as nombre'))
									->where('identificador','<','50')
									->groupBy(DB::raw('identificador'))
									->orderBy(DB::raw('MAX(nombre)'), 'asc')
									->get();


		return $sedes;

	}


	public function arraytrabajadoresaltabaja($idtrabajador) {

		$arrayempresa   	=	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  		=	Local::whereIn('empresa_id',$arrayempresa)->pluck('id')->toArray();

		$trabajador  		=	Trabajador::where('id','=',$idtrabajador)->first();


		$arraytrabajadores  =	Trabajador::whereIn('local_id',$arraylocales)->where('dni','=',$trabajador->dni)->pluck('id')->toArray();
		return $arraytrabajadores;

	}

	public function guardarhuellaanterior($dni){

		$trabajador = Trabajador::where('dni','=',$dni)->where('activo','=',0)->first();

		Trabajador::where('dni','=',$dni)
						->where('activo','=',1)
						->update(['template' => $trabajador->template , 'template10' => $trabajador->template10 , 'mar_huella' => $trabajador->mar_huella 
									, 'mar_dni' => $trabajador->mar_dni , 'huella_foto' => $trabajador->huella_foto ,'tiene' => $trabajador->tiene ]);


	}

	public function getquitarhorariotrabajadorbaja($fecha,$trabajador_id){

		$fecha 	= date_format(date_create($fecha), 'Y-m-d');
	  	$semana =  Semana::where('fechainicio', '<=',$fecha)
	  			   ->where('fechafin', '>=',$fecha)
	  			   ->first();

		Horariotrabajador::where('trabajador_id','=',$trabajador_id)
						->where('semana_id','>',$semana->id)
						->update(['activo' => '0' , 'luh' => 0 , 'mah' => 0 , 'mih' => 0 , 'juh' => 0 
									, 'vih' => 0 , 'sah' => 0 ,'doh' => 0 ]);


	}



	public function gettienehorariosemana($idhorariotrabajadores) {


		$mensaje					=   'Realizado con éxito';
		$error						=   false;

		$horario 					=   Horariotrabajador::where('id','=', $idhorariotrabajadores)
										->where('activo','=',1)
										->where(function ($query) {
							                $query->orWhere('luh', '=', 1)
							                	  ->orWhere('mah', '=', 1)
							                	  ->orWhere('mih', '=', 1)
							                	  ->orWhere('juh', '=', 1)
							                	  ->orWhere('vih', '=', 1)
							                	  ->orWhere('sah', '=', 1)
							                      ->orWhere('doh', '=', 1);
							            })->get();

		if(count($horario)){
			$mensaje = 'Tiene asignado un horario este trabajador';
			$error   = true;
		}		

		$descvaca      				= 	Descansovacacion::where('horariotrabajador_id','=', $idhorariotrabajadores)
										->where('activo','=',1)->get();


		if(count($descvaca)){
			$mensaje = 'Tiene asignado vacaciones o descanso este trabajador';
			$error   = true;
		}	

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}


	public function getUltimaMarcacion($idhorariotrabajadores,$dia,$cantmarc) {

		$diacant					= 	$dia.'cant';
		$mensaje					=   'Realizado con exito';
		$error						=   false;
		$cantmarc 					= 	(int)$cantmarc;

		$asistencia 				=   Asistenciatrabajador::where('id','=', $idhorariotrabajadores)
										->select($diacant)->first();

		if($cantmarc < $asistencia->$diacant){
			$mensaje = 'Existe marcaciones posteriores que tiene que eliminar';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}


	public function getMarcacionanterior($idhorariotrabajadores,$dia,$cantmarc) {

		$diacant					= 	$dia.'cant';
		$mensaje					=   'Realizado con exito';
		$error						=   false;
		$cantmarc 					= 	(int)$cantmarc;

		$asistencia 				=   Asistenciatrabajador::where('id','=', $idhorariotrabajadores)
										->select($diacant)->first();

		if($cantmarc-1 > $asistencia->$diacant){
			$mensaje = 'Existe marcaciones anteriores que tiene que actualizar';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}


	public function getEntradavacio($entrada,$hora) {

		$mensaje					=   'Realizado con exito';
		$error						=   false;


		if($entrada == 1 and  $hora == ''){
			$mensaje = 'La hora de entrada tiene que ser diferente al vacio';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}

	public function gethorario($idhorario,$atributo) {

		$horario 				=   Horario::where('id','=', $idhorario)
										->select($atributo)
										->first();							

		return $horario->$atributo;

	}

	
	public function getcolormarco($idasistencia,$dia,$valor) {

		$diacant					=   $dia.'cant';
		$class						=   '';

		$asistencia 				=   Asistenciatrabajador::where('id','=', $idasistencia)
										->where($diacant,'>=', $valor)
										->first();

		if(count($asistencia)>0){
			$class = 'color-marco';
		}								

		return $class;

	}

	public function getDiaSiguiente($idhorariotrabajadores,$dia) {

		$mensaje					=   'Realizado con exito';
		$error						=   false;
		$fecha 						=   Asistenciatrabajador::where('id','=', $idhorariotrabajadores)
										->select($dia)->first();

		if($fecha->$dia > date('Y-m-d')){
			$mensaje = 'La fecha seleccionda es posterior a la fecha actual';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}

	public function horaasistencia($hora) {
		$horas = '23';
		if($hora != ''){
			$horas = substr($hora, 0, 2);
		}
		return $horas;

	}	

	public function minutosasistencia($hora) {

		$minutos = '59';
		if($hora != ''){
			$minutos = substr($hora, 3, 2);
		}
		return $minutos;

	}	


	public function arrayareastrabajador($area_id,$empresa_id) {

		$arrayareas				= 	DB::table('areas')->where('id','=',$area_id)->pluck('id')->toArray();
		if($area_id == '1'){


			$tempresa  				= 	Empresa::where('id','=',$empresa_id)->first();
			$locales   				= 	Local::where('empresa_id','=',$tempresa->id)->get();

		    $arrayarea=array(-1);
		    $i = 0;
			foreach($locales as $item){
				foreach($item->trabajador as $item2){
					$arrayarea[$i]=$item2->area_id;
					$i = $i+1;
				}
			}
			$arrayareas = $arrayarea;

		}

		return $arrayareas;

	}	
		
	function stringvacacionesdescanso($idhorario,$fecha){

		$seleccion = '';
		$listvacadesc = Descansovacacion::where('horariotrabajador_id','=',$idhorario)
                                      ->where('fecha','=',$fecha)
                                      ->where('activo','=','1')
                                      ->first();
        if(count($listvacadesc)>0){

        	if($listvacadesc->estado == 'v'){
	        	$seleccion = 'Vac.';
	        }else{
	        	$seleccion = 'Des.';
	        }
        }                              
        return $seleccion;
	}


	function stringvacacionesdescansoexcel($idhorario,$fecha){

		$seleccion = '';
		$listvacadesc = Descansovacacion::where('horariotrabajador_id','=',$idhorario)
                                      ->where('fecha','=',$fecha)
                                      ->where('activo','=','1')
                                      ->first();
        if(count($listvacadesc)>0){

        	if($listvacadesc->estado == 'v'){
	        	$seleccion = 'V';
	        }else{
	        	$seleccion = 'D';
	        }
        }                              
        return $seleccion;
	}


	public function gettienevacacionesodescanso($idhorariotrabajadores,$dia) {


		$mensaje					=   'Realizado con exito';
		$error						=   false;
		$listvacadesc 				= 	Descansovacacion::where('horariotrabajador_id','=',$idhorariotrabajadores)
                                      	->where('prefijo','=',$dia)
                                      	->where('activo','=','1')                                      
                                      	->get();

		if(count($listvacadesc) > 0){
			$mensaje = 'Este horario ya tiene vacaciones o descanso';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}

	function activovaca($fecha,$idhorario){

		$seleccion = '0';
		$listvacadesc = Descansovacacion::where('horariotrabajador_id','=',$idhorario)
                                      ->where('fecha','=',$fecha)
                                      ->where('estado','=','v')
                                      ->where('activo','=','1')
                                      ->get();
        if(count($listvacadesc)>0){
        	$seleccion = '1';
        }                              
        return $seleccion;
	}

	function activodesc($fecha,$idhorario){

		$seleccion = '0';
		$listvacadesc = Descansovacacion::where('horariotrabajador_id','=',$idhorario)
                                      ->where('fecha','=',$fecha)
                                      ->where('estado','=','d')
                                      ->where('activo','=','1')                                      
                                      ->get();
        if(count($listvacadesc)>0){
        	$seleccion = '1';
        }                              
        return $seleccion;
	}



	function activovacadesc($fecha,$idhorario){

		$seleccion = '0';
		$listvacadesc = Descansovacacion::where('horariotrabajador_id','=',$idhorario)
                                      ->where('fecha','=',$fecha)
                                      ->get();
        if(count($listvacadesc)>0){
        	$seleccion = '1';
        }                              
        return $seleccion;
	}

	function seleccionvacadesc($fecha,$idhorario,$estado){

		$seleccion = '';
		$listvacadesc = Descansovacacion::where('horariotrabajador_id','=',$idhorario)
                                      ->where('fecha','=',$fecha)
                                      ->where('estado','=',$estado)
                                      ->where('activo','=','1')
                                      ->get();

        if(count($listvacadesc)>0){
        	$seleccion = 'seleccion';
        }                              

        return $seleccion;
	}

	function reporteindividualarray($arraytrabajadores,$arraysemanas){


     	$listaasistencia        =   Horariotrabajador::whereIn('trabajador_id',$arraytrabajadores)
			                    ->whereIn('semana_id',$arraysemanas)
			                    ->orderBy('semana_id', 'asc')
			                    ->get(); 

        return $listaasistencia;
	}


	function reporteindividual($trabajador_id,$arraysemanas){


     	$listaasistencia        =   Horariotrabajador::where('trabajador_id','=',$trabajador_id)
			                    ->whereIn('semana_id',$arraysemanas)
			                    ->orderBy('semana_id', 'asc')
			                    ->get(); 

        return $listaasistencia;
	}

	function minutosdoshoras($horamenor,$horamayor){
		$carbon1 = new \Carbon\Carbon("2019-01-01 ".$horamenor.":00");
		//convertimos la fecha 2 a objeto Carbon
		$carbon2 = new \Carbon\Carbon("2019-01-01 ".$horamayor.":00");
		//de esta manera sacamos la diferencia en minutos
		$m=(int)$carbon1->diffInMinutes($carbon2);
		return $m;
	}

	function formatohorasminutos($m){
		$h = (int)($m/60);
		$m -= $h*60;
		return (string)$h.'h:'.$m.'m';
	}


	public function getsemanatieneasistencia($idsemana) {

		$mensaje					=   'Realizado con exito';
		$error						=   false;

		$asistencia 				=   Asistenciatrabajador::where('semana_id', '=', $idsemana)
							            ->where(function ($query) {
					                		$query->where('lucant', '>', 0)
					                		->orwhere('lucant', '>', 0)
					                		->orwhere('macant', '>', 0)
					                		->orwhere('micant', '>', 0)
					                		->orwhere('jucant', '>', 0)
					                		->orwhere('vicant', '>', 0)
					                		->orwhere('sacant', '>', 0)
					                      	->orwhere('docant', '>', 0);
					            		})->get();


		if(count($asistencia)  > 0){
			$mensaje = 'Existe asistencia en esta semana no se puede clonar';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}


	public function gettieneasistencia($idhorariotrabajadores,$diacant) {


		$mensaje					=   'Realizado con exito';
		$error						=   false;
		$asistencia 				= 	DB::select('select horariotrabajador_id from asistenciatrabajadores where horariotrabajador_id = :id and '.$diacant.' > :dia', ['id' => $idhorariotrabajadores,'dia' => 0]);


		if(count($asistencia) > 0){
			$mensaje = 'Este horario ya tiene una asistecia (Comunicarse con el area de sistemas)';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}

	public function arraytrabajadorespermiso() {
		$arrayempresa   	=	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  		=	Local::whereIn('empresa_id',$arrayempresa)->pluck('id')->toArray();
		$arraytrabajadores  =	Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();
		return $arraytrabajadores;
	}

	public function arraysedetrabajadorespermiso($idsede) {
		$arrayempresa   	=	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  		=	Local::whereIn('empresa_id',$arrayempresa)->where('identificador','=',$idsede)->pluck('id')->toArray();
		$arraytrabajadores  =	Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();
		return $arraytrabajadores;
	}

	public function arraysedeempresatrabajadores($idsede,$empresaid) {
		$arrayempresa   	=	Permisouserempresa::where('activo','=',1)->where('empresa_id','=',$empresaid)
								->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  		=	Local::whereIn('empresa_id',$arrayempresa)->where('identificador','=',$idsede)->pluck('id')->toArray();
		$arraytrabajadores  =	Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();
		return $arraytrabajadores;
	}


	public function arraylocalespermiso() {
		$arrayempresa   =	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  =	Local::whereIn('empresa_id',$arrayempresa)->pluck('id')->toArray();
		return $arraylocales;
	}


	public function arraylocalessedepermiso($idsede) {
		$arrayempresa   =	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  =	Local::whereIn('empresa_id',$arrayempresa)->where('identificador','=',$idsede)->pluck('id')->toArray();
		return $arraylocales;
	}

	/***	sedes y empresa ***/
	public function arraylocalessedesempresapermiso($idsede,$idempresa) {

		$arrayempresa   =	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  =	Local::whereIn('empresa_id',$arrayempresa)->where('identificador','=',$idsede)->where('empresa_id','=',$idempresa)->pluck('id')->toArray();
		return $arraylocales;
	}	



	/***	sedes ***/
	public function arraylocalessedespermiso($idsede) {

		$arrayempresa   =	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  =	Local::whereIn('empresa_id',$arrayempresa)->where('identificador','=',$idsede)->pluck('id')->toArray();
		return $arraylocales;
	}	


	public function arraytrabajadoressedespermiso($idsede) {
		$arrayempresa   	=	Permisouserempresa::where('activo','=',1)
								->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		$arraylocales  		=	Local::whereIn('empresa_id',$arrayempresa)->where('identificador','=',$idsede)->pluck('id')->toArray();
		$arraytrabajadores  =	Trabajador::whereIn('local_id',$arraylocales)->pluck('id')->toArray();
		return $arraytrabajadores;
	}
	/****************/

	public function arrayempresapermiso() {
		$arrayempresa   =	Permisouserempresa::where('activo','=',1)->where('user_id','=',Session::get('usuario')->id)->pluck('empresa_id')->toArray();
		return $arrayempresa;
	}
	
	public function semanas($fechainicio,$fechafin) {

		$semanas 				= 	Semana::where('activo','=',1)->orderBy('id', 'asc')->get();

		$array = [];
		$sw=0;
		foreach($semanas as $key => $item){

			if($fechainicio >= $item->fechainicio && $fechainicio <= $item->fechafin){
				$array = array_add($array, $key, $item->id);
				$sw=1;
			}

			if($sw == 1){
				if($fechafin >= $item->fechafin){
					$array = array_add($array, $key, $item->id);
				}else{
					$array = array_add($array, $key, $item->id);
					$sw=2;
				}
			}
		

		}


		return $array;
	}

	public function comboidencriptadotodos($tabla,$titulo) {

		$array = ['' => $titulo,'1' => 'TODOS']; // creo el array
		foreach ($tabla as $key => $value) {
			$key = Hashids::encode(substr($key, -12));
			$array = array_add($array, $key, $value);
		}

		return $array;
	}
	
	public function sumarminutos($hora,$minutos){
	    $carbon = new \Carbon\Carbon();
	    $fecha = $carbon::createFromFormat('Y-m-d H:i:s', '2000-01-01 '.$hora.':00')->addMinute($minutos)->toDateTimeString();
	    $hora = substr($fecha, 11, 5);
	    return $hora;
	}

	public function restarminutos($hora,$minutos){
	    $carbon = new \Carbon\Carbon();
	    $fecha = $carbon::createFromFormat('Y-m-d H:i:s', '2000-01-01 '.$hora.':00')->subMinute($minutos)->toDateTimeString();
	    $hora = substr($fecha, 11, 5);
	    return $hora;
	}
	
	public function nombredia($fecha) {

		$fecha 	= date_format(date_create($fecha), 'Y-m-d');
		$dias = array('do','lu','ma','mi','ju','vi','sa');
		$fecha = $dias[date('w', strtotime($fecha))];
		return $fecha;
	}


	public function idsemana($fecha) {

		$fecha 	= date_format(date_create($fecha), 'Y-m-d');
	  	$semana =  Semana::where('fechainicio', '<=',$fecha)
	  			   ->where('fechafin', '>=',$fecha)
	  			   ->first();

	  	return $semana->id;
	}



	public function comboidencriptado($tabla,$titulo) {

		$array = ['' => $titulo]; // creo el array
		foreach ($tabla as $key => $value) {
			$key = Hashids::encode(substr($key, -12));
			$array = array_add($array, $key, $value);
		}

		return $array;
	}

	public function getUrl($idopcion,$acion) {

	  	//decodificar variable
	  	$decidopcion = Hashids::decode($idopcion);
	  	//ver si viene con letras la cadena codificada
	  	if(count($decidopcion)==0){ 
	  		return Redirect::back()->withInput()->with('errorurl', 'Indices de la url con errores'); 
	  	}

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($decidopcion[0], 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

	  	// hemos hecho eso porque ahora el prefijo va hacer fijo en todas las empresas que PRMAECEN
		//$prefijo = Local::where('activo', '=', 1)->first();
		//$idopcioncompleta = $prefijo->prefijoLocal.$idopcioncompleta;
		$idopcioncompleta = 'PRMAECEN'.$idopcioncompleta;

	  	// ver si la opcion existe
	  	$opcion =  RolOpcion::where('opcion_id', '=',$idopcioncompleta)
	  			   ->where('rol_id', '=',Session::get('usuario')->rol_id)
	  			   ->where($acion, '=',1)
	  			   ->first();

	  	if(count($opcion)<=0){
	  		return Redirect::back()->withInput()->with('errorurl', 'No tiene autorización para '.$acion.' aquí');
	  	}
	  	return 'true';

	 }

	public function decodificar($id) {

	  	//decodificar variable
	  	$iddeco = Hashids::decode($id);
	  	//ver si viene con letras la cadena codificada
	  	if(count($iddeco)==0){ 
	  		return ''; 
	  	}

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($iddeco[0], 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();

		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no 
		//¿cuando sea el contrato del local?
		$prefijo = Session::get('local')->prefijoLocal;
		$idopcioncompleta = $prefijo.$idopcioncompleta;
	  	
	  	return $idopcioncompleta;

	}

	public function decodificarmaestra($id) {

	  	//decodificar variable
	  	$iddeco = Hashids::decode($id);
	  	//ver si viene con letras la cadena codificada
	  	if(count($iddeco)==0){ 
	  		return ''; 
	  	}
	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($iddeco[0], 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();

		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no 
		//¿cuando sea el contrato del local?
		$prefijo = 'PRMAECEN';
		$idopcioncompleta = $prefijo.$idopcioncompleta;
	  	return $idopcioncompleta;

	}

	public function idmaestra() {

		$prefijo = 'PRMAECEN';
	  	return $prefijo;
	}




	public function getCreateIdT($tabla) {

  		$id="";


  		// maximo valor de la tabla referente
		$id = DB::table($tabla)
        ->select(DB::raw('max(SUBSTRING(id,9,12)) as id'))
        ->get();

        //conversion a string y suma uno para el siguiente id
        $idsuma = (int)$id[0]->id + 1;

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($idsuma, 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
	  	// ahora el prefijo deberia venir del local que seleccionamos verdad ?si
		//$prefijo = Local::where('activo', '=', 1)->first()->prefijoLocal;
		$prefijo = Session::get('local')->prefijoLocal;

		$idopcioncompleta = $prefijo.$idopcioncompleta;

  		return $idopcioncompleta;	

	}

	public function getCreateId($tabla) {

  		$id="";


  		// maximo valor de la tabla referente
		$id = DB::table($tabla)
        ->select(DB::raw('max(SUBSTRING(id,9,12)) as id'))
        ->where('local_id','=', Session::get('local')->id)
        ->get();

        //conversion a string y suma uno para el siguiente id
        $idsuma = (int)$id[0]->id + 1;

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($idsuma, 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
	  	// ahora el prefijo deberia venir del local que seleccionamos verdad ?si
		//$prefijo = Local::where('activo', '=', 1)->first()->prefijoLocal;
		$prefijo = Session::get('local')->prefijoLocal;

		$idopcioncompleta = $prefijo.$idopcioncompleta;

  		return $idopcioncompleta;	

	}

	public function getCreateIdMaestra($tabla) {

  		$id="";

  		// maximo valor de la tabla referente
		$id = DB::table($tabla)
        ->select(DB::raw('max(SUBSTRING(id,9,12)) as id'))
        ->get();

        //conversion a string y suma uno para el siguiente id
        $idsuma = (int)$id[0]->id + 1;

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($idsuma, 12, "0", STR_PAD_LEFT);

	  	//concatenar prefijo
		$prefijo = 'PRMAECEN';

		$idopcioncompleta = $prefijo.$idopcioncompleta;

  		return $idopcioncompleta;	

	}


	public function getEmpresa() {

		$empresa 	= Empresa::where('activo','=', 1)->first();
  		return $empresa;	
	}

	public function cargar_trabajadores_nuevos($idsemana,$arraylocales,$fechainicio) {


		$arraytrabajadoresnuevos 	=   Trabajador::leftJoin('horariotrabajadores', function($join) use ($idsemana)
									    {
									        $join->on('trabajadores.id', '=', 'horariotrabajadores.trabajador_id')
									        ->where('horariotrabajadores.semana_id', $idsemana);
									    })
										->select(DB::raw("trabajadores.id, trabajadores.apellidopaterno + ' ' + trabajadores.apellidomaterno + ' ' + trabajadores.nombres  as descripcion"))
										->whereNull('horariotrabajadores.trabajador_id')
										->where('trabajadores.activo','=',1)
										->whereIn('trabajadores.local_id',$arraylocales)
										->pluck('trabajadores.id')
										->toArray();


		$listatrabajadores 		= 	Trabajador::whereIn('id',$arraytrabajadoresnuevos)
							 		->get();

		foreach($listatrabajadores as $item){


			$idhorariotrabajador 		= 	$this->getCreateId('horariotrabajadores');
			$idasistenciatrabajadores 	= 	$this->getCreateId('asistenciatrabajadores');

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

		return true;
	}


	
	public function getDiaAnterior($idhorariotrabajadores,$dia) {

		$mensaje					=   'Realizado con exito';
		$error						=   false;
		$fecha 						=   Horariotrabajador::where('id','=', $idhorariotrabajadores)
										->select($dia)->first();

		if($fecha->$dia < date('Y-m-d')){
			$mensaje = 'La fecha seleccionda es anterior a la fecha actual';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}


}

