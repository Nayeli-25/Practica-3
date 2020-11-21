<?php

namespace App\Http\Middleware;

use App\Models\Comentarios;
use App\Http\Controllers\ApiMail\ApiMailController;
use Closure;

class LimitCommentary
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
        $comentario=Comentarios::find($request->id);

        if (auth()->check() && auth()->user()->Rol==2){

            if ($comentario->persona_id == auth()->user()->id)
                return $next($request);
            else {
                $action='actualizar o eliminar un comentario que no es de su propiedad';
                app(ApiMailController::class)->MailAccionDenegada($action);
                return response()->json( 'Requieres permisos para realizar esta acción',400);
            }
        }
        return $next($request);
    }
}
