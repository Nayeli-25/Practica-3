<?php

namespace App\Http\Controllers;
use App\Models\Productos;


use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function getProductos ($id=null)
    {
        if ($id)
            return response()->json(["Producto"=>Productos::find($id)],200);
        return response()->json(["Productos"=>Productos::all()],200);
    }
    public function createProducto(Request $request)
    {
        $producto = new Productos;

        $producto->Producto = $request->Producto;
        $producto->Publicado_por = auth()->user()->id;

        if($producto->save())
            return response()->json(["Nuevo producto"=>$producto],201);
    
        return response()->json(null,400);
    }
    public function updateProducto(Request $request, $id)
    {
        $ProductoActualizado = Productos::find($id);
        $ProductoActualizado->Producto = $request->Producto;
        if (auth()->user()->Rol==2)
            $ProductoActualizado->Publicado_por = auth()->user()->id;
        else 
            $ProductoActualizado->Publicado_por = $request->Publicado_por;
        
        if ($ProductoActualizado->save())
            return response()->json(["Nuevos datos del producto"=>$ProductoActualizado],200);

        return response()->json(null,400);
    }
   
    public function deleteProducto($id){

        $ProductoEliminado = Productos::findOrFail($id);
        
        if($ProductoEliminado ->delete())
            return response()->json("Producto eliminado correctamente",200);

        return response()->json(null,400);
    }
}
