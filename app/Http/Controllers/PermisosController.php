<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PermisosController extends Controller
{
    public function otorgarPermisos($id)
    {
        $usuario = User::find($id);
        $usuario->Rol = 1;
        
        if($usuario->save())
            return response()->json("El usuario ahora es administrador",200);  
        
        return response()->json(null,400);
    }

    public function revocarPermisos($id)
    {
        $usuario = User::find($id);
        $usuario->Rol = 2;
        
        if($usuario->save())
            return response()->json("El usuario ya no tiene permisos de administrador",200);  
        
        return response()->json(null,400);
    }
}
