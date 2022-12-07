<?php

namespace App\Http\Middleware;

use Closure;

class impersonate
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
        if($request->session()->has('impersonate'))
        {
            \Auth::onceUsingId($request->session()->get('impersonate'));
        }

        return $next($request);
    }
}
