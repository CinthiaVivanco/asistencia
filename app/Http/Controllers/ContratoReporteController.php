<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Contrato,App\Trabajador;
use View;
use Session;
use Hashids;
use PDF;


class ContratoReporteController extends Controller
{

	public function actionContratoPdf($idcontrato)
	{

		$idcontrato 		= 	$this->funciones->decodificar($idcontrato);
		$contrato 			= 	Contrato::where('id','=',$idcontrato)->first();
		$titulo				= 	"Contrato de personal";
		$vistacontrato		=	"";


		if($contrato->formato->numero == 1){
			$vistacontrato = "contrato01";
		}else{
			if($contrato->formato->numero == 2){
				$vistacontrato = "contrato02";
			}else{
				$vistacontrato = "contrato03";
			}
		}


		$pdf 			= 	PDF::loadView('contrato.pdf.'.$vistacontrato, 
											[ 
												'contrato' 		  	  => $contrato,
												'titulo' 		  	  => $titulo,												
											]);


		return $pdf->stream('download.pdf');



	}


}
