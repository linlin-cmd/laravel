<?php

namespace App\Http\Middleware;

use Closure;

class Grant
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
        $user =session('grant');
        if (!$user) {
            return redirect('grant/login');
        }
        return $next($request);
    }
}
