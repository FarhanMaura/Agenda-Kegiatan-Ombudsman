<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
