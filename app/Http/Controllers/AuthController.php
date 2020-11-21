<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function verificar($codigo){
        $usuario = User::where('codigo_confirmacion', $codigo)->first();

        if(! $usuario)
            return abort(400, 'Información no confirmada');
        
        $usuario->confirmado = true;
        $usuario->codigo_confirmacion = null;
        $usuario->save();
        return abort(200, 'Tu cuenta ha sido activada');
    }

    public function logIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'Contraseña' => 'required',
        ]);
        
        $usuario = User::where('email', $request->email)->first();

        if(!$usuario || !Hash::check($request->Contraseña, $usuario->Contraseña)){
            throw ValidationException::withMessages([
                'email | contraseña' => ['Datos erróneos']
            ]);
        }
        Log::info('estado '.$usuario->confirmado);
        if($usuario->confirmado==true)
        {
            if ($usuario->Rol==1){
                $token = $usuario->createToken($request->email, ['admin:admin'])->plainTextToken;
                return response()->json(['token' => $token], 200);
            }
            else{
                $token = $usuario->createToken($request->email, ['user:info'])->plainTextToken;
                return response()->json(['token' => $token], 200);
            }
        }
        return abort(400, 'La cuenta no ha sido activada');
    }
    
    public function inicio(Request $request)
    {
        if($request->user()->tokenCan('admin:admin'))
            return response()->json(['Usuarios'=>User::all()],200);

        if($request->user()->tokenCan('user:info'))
            return response()->json(["Mi perfil"=> $request->user()],200);
        
        return response()->json('No se ha iniciado sesión',422);
    }

    public function logOut(Request $request)
    {
        return response()->json(["Se cerró la sesión"=> $request->user()->tokens()->delete()],200);
    }
}