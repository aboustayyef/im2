<?php

namespace App\Http\Middleware;

use Closure;

class UserLoggedIn
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
        if (\Session::has('userCanLogin')) {
            return $next($request);
        }
        return redirect('/login');
    }
}
