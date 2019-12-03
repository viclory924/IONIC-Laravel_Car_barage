<?php


namespace App\Http\Middleware;


use Closure;

class userActive
{

    public function handle($request, Closure $next)
    {
        if($request->user()->active){
            return $next($request);
        }else{
            abort(401);
        }
    }
}
