<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow regular users to access mypage routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'user') {
            return redirect()->route('admin.dashboard')->with('error', 'このページにはアクセスできません。');
        }

        return $next($request);
    }
}

