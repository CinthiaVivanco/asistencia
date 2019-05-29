<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\User,App\Maestro,App\Ilog,App\ListaPiloto,App\Empresa,App\Local;
use Mail;


class EmailCumpleaniosConductores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conductor:cumpleanios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proceso de envio de email para cumpleanios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {



        $dia                            = date("j");
        $mes                            = date("n");

        // trabajadores que solo trabajan para ia
        $listatrabajadores              = ListaPiloto::whereRaw('day(FechaNacimiento)='. $dia .'and month(FechaNacimiento)='.$mes)
                                          ->get();


        $envio                          = 'No';


        foreach($listatrabajadores as $item){

            $data               =   ListaPiloto::select('listapiloto.Id as id','listapiloto.Nombre as nombres','listapiloto.ApellidoPaterno as apellidopaterno','listapiloto.ApellidoMaterno as apellidomaterno','listapiloto.Dni as dni','listapiloto.NombreCargo as nombre','listapiloto.sede as sede')
                                    ->where('listapiloto.Id','=',$item->Id)
                                    ->first();

            $array              =   $data->toArray();


            // correos from(de)
            $emailfrom = Maestro::where('codigoatributo','=','0002')->where('codigoestado','=','00001')->first();
            // correos principales y  copias
            $email     = Maestro::where('codigoatributo','=','0002')->where('codigoestado','=','00002')->first();


            Mail::send('emails.cumpleanosisl', $array, function($message) use ($emailfrom,$email)
            {

                $emailprincipal     = explode(",", $email->correoprincipal);
                
                $message->from($emailfrom->correoprincipal, 'SALUDO DE CUMPLEAÑOS');

                if($email->correocopia<>''){
                    $emailcopias        = explode(",", $email->correocopia);
                    $message->to($emailprincipal)->bcc($emailcopias);
                }else{
                    $message->to($emailprincipal);                
                }
                $message->subject($email->descripcion);

            });

            $envio                          = 'Si';

        }

        $fechatime                           = date("Ymd H:i:s");
        $fecha                               = date("Ymd");

        $cabecera                            = new Ilog;
        $cabecera->descripcion               = '(Sistema) Envio de correos de cumpleaños - '.$envio;
        $cabecera->fecha                     = $fecha;
        $cabecera->fechatime                 = $fechatime;
        $cabecera->save();

        Log::info("Correo Enviado");


    }
}
