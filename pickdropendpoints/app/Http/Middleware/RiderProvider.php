<?php

namespace App\Http\Middleware;

use Closure;

class RiderProvider
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
        config(['auth.gaurd.api.provider' => 'riders']);
        return $next($request);
    }
}
