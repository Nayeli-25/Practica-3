<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\ApiMail\ApiMailController;
use Closure;

class CheckRole
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
        if (auth()->check() && auth()->user()->Rol==2){
            $action='otorgar o revocar permisos a algún usuario';
            app(ApiMailController::class)->MailAccionDenegada($action);
            return response()->json( 'Requieres permisos para realizar esta acción',400);
        }
        return $next($request);
    }
}