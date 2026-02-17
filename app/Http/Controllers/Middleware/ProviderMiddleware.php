<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isProvider() || !Auth::user()->isApproved()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}