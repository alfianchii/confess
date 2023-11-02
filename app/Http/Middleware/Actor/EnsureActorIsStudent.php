<?php

namespace App\Http\Middleware\Actor;

use Closure;
use Illuminate\Http\Request;

class EnsureActorIsStudent
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
        $role = auth()->user()->userRole->role->role_name;
        if (auth()->guest() or $role !== "student") {
            abort(403);
        }

        return $next($request);
    }
}
