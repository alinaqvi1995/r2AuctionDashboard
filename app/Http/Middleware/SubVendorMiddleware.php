<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubVendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if ($request->user() && $request->user()->isSubVendor()) {
            return $next($request);
        }

        // If not an admin, redirect to unauthorized page or return a 403 response
        return redirect()->route('unauthorized');
    }
}
