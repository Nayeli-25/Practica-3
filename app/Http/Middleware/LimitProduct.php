<?php

namespace App\Http\Middleware;

use App\Models\Productos;
use App\Http\Controllers\ApiMail\ApiMailController;
use Closure;

class LimitProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $producto=Productos::find($request->id);

        if (auth()->check() && auth()->user()->Rol==2){

            if ($producto->Publicado_por == auth()->user()->id)
                return $next($request);
            
            else {
                $action='actualizar o eliminar un producto que no es de su propiedad';
                app(ApiMailController::class)->MailAccionDenegada($action);
                return response()->json( 'Requieres permisos para realizar esta acción',400);
            }
        }
        return $next($request);
    }
}
