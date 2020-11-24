<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Http\Controllers\ApiMail\ApiMailController;
use Closure;

class LimitUser
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
        if (auth()->check() && auth()->user()->Rol==2)
        {
            if (auth()->user()->id==$request->id) 
                return $next($request);
            
            else {
                $action='actualizar o eliminar los datos de otro usuario';
                app(ApiMailController::class)->MailAccionDenegada($action);
                return response()->json( 'Requieres permisos para realizar esta acción',400);
            }
        }
        return $next($request);
    }
}
