<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class revisar_perfil
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
        $quien=new User();
        if(\Auth::check()) {
            $quien=\Auth::user();
            $puede_pasar = $quien->tiene_perfil();
        }
        else {
            return redirect('/inicio');
        }

        if (!$puede_pasar ) {
            return redirect()->action('entrevistadorController@create');
        }

        if(\Auth::user()->id_nivel == 99) { //Deshabilitado
            return redirect()->action('entrevistadorController@deshabilitado');
        }


        //Aceptar compromiso de reserva
        if (!\Request::is('compromiso')) {
            if(config('expedientes.solicitar_compromiso')) {
                if($quien->rel_entrevistador->compromiso_reserva == 0 ) {
                    return redirect()->action('entrevistadorController@solicitar_compromiso');
                }
            }
        }



        return $next($request);
    }
}
