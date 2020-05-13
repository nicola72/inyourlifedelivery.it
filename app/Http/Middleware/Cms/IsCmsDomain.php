<?php
namespace App\Http\Middleware\Cms;

use Closure;

class IsCmsDomain
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
        $domain = $_SERVER['HTTP_HOST'];
        if($domain != 'inyourlifedelivery.it' && $domain != 'www.inyourlifedelivery.it')
        {
            return redirect('/');
        }
        return $next($request);
    }
}