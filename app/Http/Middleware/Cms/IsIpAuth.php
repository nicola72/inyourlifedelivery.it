<?php

namespace App\Http\Middleware\Cms;

use Closure;

class IsIpAuth
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
        $ip_auth = config('cms.ip_auth');
        if(!in_array($request->ip(),$ip_auth))
        {
            return redirect('/cms');
        }
        return $next($request);
    }
}
