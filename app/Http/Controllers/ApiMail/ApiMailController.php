<?php

namespace App\Http\Controllers\ApiMail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Mailjet\Resources;

class ApiMailController extends Controller
{
    public function sendMailConfirmacion (Request $request){
        
        $apikey = config('app.mjapikeypub');
        $apisecret = config('app.mjapikeypriv');

        $nombre=$request->Nombre;
        $email=$request->email;
        $codigo = $request->codigo_confirmacion;

        $mj = new \Mailjet\Client($apikey,$apisecret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "19170139@uttcampus.edu.mx",
                'Name' => "Nayeli Esquivel"
                ],
                'To' => [
                [
                    'Email' => $email,
                    'Name' => $nombre 
                ]
                ],
                'Subject' => "Activación de cuenta",
                'TextPart' => "¡Bienvenido!",
                'HTMLPart' => "<h1> ¡Bienvenido, {$nombre}!</h1> <br> <h3>Para activar tu cuenta da click <a href='http://127.0.0.1:8000/api/confirmarUsuario/{$codigo}'> aquí </a> </h3>",
                'CustomID' => "AppGettingStartedTest"
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        //$response->success() && var_dump($response->getData()); 
        if($response->success())
            return response()->json(["Información" => $response->getData()],200);
        return response()->json(["Información" => $response->getData()],500);
    }


    public function MailAccionDenegada($action) {

        $apikey = config('app.mjapikeypub');
        $apisecret = config('app.mjapikeypriv');

        $nombre=auth()->user()->Nombre;
        $apellido=auth()->user()->Apellido;
        $email=auth()->user()->email;

        $mj = new \Mailjet\Client($apikey,$apisecret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "19170139@uttcampus.edu.mx",
                'Name' => "Nayeli Esquivel"
                ],
                'To' => [
                [
                    'Email' => "19170139@utt.edu.mx",
                    'Name' => "Nayeli Esquivel"
                ]
                ],
                'Subject' => "Acción Denegada",
                'TextPart' => "Acción Denegada",
                'HTMLPart' => "<h3> El usuario {$nombre} {$apellido}, con email {$email}, intentó {$action}, pero no cuenta con la autorización requerida para realizar la acción. </h3>",
                'CustomID' => "AppGettingStartedTest"
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if($response->success())
            return response()->json(["Datos" => $response->getData()],200);
        return response()->json(["Datos" => $response->getData()],500);
    }


    public function MailAddCommentary($producto) {

        $apikey = config('app.mjapikeypub');
        $apisecret = config('app.mjapikeypriv');

        $nombre=auth()->user()->Nombre;
        $email=auth()->user()->email;

        $mj = new \Mailjet\Client($apikey,$apisecret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "19170139@uttcampus.edu.mx",
                'Name' => "Nayeli Esquivel"
                ],
                'To' => [
                [
                    'Email' => $email,
                    'Name' => $nombre
                ]
                ],
                'Subject' => "Nuevo comentario añadido",
                'TextPart' => "Nuevo cometario",
                'HTMLPart' => "<h3> Tu comentario al producto '{$producto}' se realizó de manera exitosa. </h3>",
                'CustomID' => "AppGettingStartedTest"
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if($response->success())
            return response()->json(["Datos" => $response->getData()],200);
        return response()->json(["Datos" => $response->getData()],500);
    }


    public function MailReceiveCommentary($usuario, $producto) {

        $apikey = config('app.mjapikeypub');
        $apisecret = config('app.mjapikeypriv');

        $mj = new \Mailjet\Client($apikey,$apisecret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "19170139@uttcampus.edu.mx",
                'Name' => "Nayeli Esquivel"
                ],
                'To' => [
                [
                    'Email' => $usuario,
                    'Name' => "n"
                ]
                ],
                'Subject' => "Nuevo comentario añadido",
                'TextPart' => "Nuevo cometario",
                'HTMLPart' => "<h3> Se ha realzado un nuevo comentario a tu producto '{$producto}'. </h3>",
                'CustomID' => "AppGettingStartedTest"
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if($response->success())
            return response()->json(["Datos" => $response->getData()],200);
        return response()->json(["Datos" => $response->getData()],500);
    }
}
