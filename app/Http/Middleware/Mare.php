<?php

namespace App\Http\Middleware;

use Closure;

class Mare
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
        $user =session('ware');
        if (!$user) {
            return redirect('ware/login');
        }
        return $next($request);
    }
}
