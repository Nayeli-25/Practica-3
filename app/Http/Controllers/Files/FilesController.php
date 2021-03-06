<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Fecades\Storage;
use App\Models\User;
use App\Http\Controllers\ApiMail\ApiMailController;
use Illuminate\Support\Facades\Log;

class FilesController extends Controller
{
    public function SubirImagenPerfil (Request $request)
    {
        $id=auth()->user()->id;
        if ($request->hasFile('avatar')) 
        {
            $request->validate([
                'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
              ]);

            $path=\Storage::disk('local')->put("docPrivados/{$id}/Avatar", $request->avatar);
            
            Log::info('imagen '.$path);

            //obtener el nombre de la imagen
            $nombre =  time()."_".$request->avatar->getClientOriginalName();
            
            $file = auth()->user();
            $file->imagen = $nombre;
            
            if($file->save()){
                app(ApiMailController::class)->MailActualizacionPerfil();
                return response()->json(["SubidaPrivada "=>$path],201);
            }
        }
        return response()->json(['No se ha añadido ningún archivo'], 456); 
    }

    public function deleteImagen(){

        $id=auth()->user()->id;
        $usuario=User::find($id);

        if($usuario->imagen <> null) 
        {
            $usuario->imagen = null;
        
            if($usuario->save()) {
                app(ApiMailController::class)->MailActualizacionPerfil();
                return response()->json("Imagen eliminada correctamente",200);
            }
            return response()->json("No se eliminó tu imagen",400);
        }
        return response()->json(['No cuentas con alguna imagen en tu perfil'], 400); 
    }
    

    //PENDIENTES
    /*public function DescargarImagenPerfil ($imagen=null, $id){
        $usuario = User::find($id);
        $imagen = $usuario->imagen;
        Log::info('imagen '.$imagen);
        if ($imagen)
            return \Storage::download("docPrivados/{$id}/Avatar/{$imagen}");
        return response()->json(['El usuario no tiene imagen de perfil'], 456); 
    }

    /*public function SaveFilePub (Request $request){
        if ($request->hasFile('file')){
            $path=Storage::disk('public')->put('docPublicos', $request->file);
            return response()->json(["SubidaPublica"=>$path],201);
        }
        return response()->json(['No se ha añadido ningún archivo'], 456); 
    }*/
}
