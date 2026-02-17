<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isCustomer() || !Auth::user()->isApproved()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}