<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        // dd($request->user()->isAdmin());
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        // If not an admin, redirect to unauthorized page or return a 403 response
        // return redirect()->route('unauthorized');
        return redirect()->route('login');
    }
}
