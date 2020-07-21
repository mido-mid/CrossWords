<?php

namespace App\Http\Middleware;

use Closure;

class approved
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
        $user = auth()->user();
        if($user->approved == 1){
            return $next($request);
        }
        return abort(404);
    }
}
