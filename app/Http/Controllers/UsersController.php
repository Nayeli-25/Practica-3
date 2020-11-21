<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Fecades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiMail\ApiMailController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;  

class UsersController extends Controller
{
    public function getUsuarios($id = null)
    {
        if ($id)
            return response()->json(["Usuario"=>User::find($id)],200);

        return response()->json(["Usuarios"=>User::all()],200);
    }
    
    public function registrarUsuario(Request $request)
    {
        $request->codigo_confirmacion = Str::random(20);
        $request->validate([
            'Nombre' => 'required',
            'Apellido' => 'required',
            'email' => 'required|email',
            'Contraseña' => 'required',
        ]);

        $usuario = new User;

        $usuario->Nombre = $request->Nombre;
        $usuario->Apellido = $request->Apellido;
        $usuario->Edad = $request->Edad;
        $usuario->email = $request->email;
        $usuario->Contraseña = Hash::make($request->Contraseña);
        $usuario->Rol=2;
        $usuario->codigo_confirmacion = $request->codigo_confirmacion;

        if ($usuario->save()){
            app(ApiMailController::class)->sendMailConfirmacion($request);
            return response()->json(['Nuevo usuario'=>$usuario],201);
        }
    
    return response()->json('No se registró el usuario',422);
    }
    
    public function updateUsuario(Request $request, $id)
    {
        $UsuarioActualizado = User::find($id);
        $UsuarioActualizado->Nombre = $request->Nombre;
        $UsuarioActualizado->Apellido = $request->Apellido;
        $UsuarioActualizado->Edad = $request->Edad;
        $UsuarioActualizado->email = $request->email;
        $UsuarioActualizado->Contraseña = Hash::make($request->Contraseña);
        
        if ($UsuarioActualizado->save())
            return response()->json(["Nuevos datos del usuario"=>$UsuarioActualizado],200);

        return response()->json(null,400);
    }
   
    public function deleteUsuario($id){

        $UsuarioEliminado = User::findOrFail($id);
        
        if($UsuarioEliminado ->delete())
            return response()->json("Usuario eliminado correctamente",200);

        return response()->json(null,400);
    }
}
