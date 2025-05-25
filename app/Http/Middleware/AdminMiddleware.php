<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * check if user isAdmin than can access routes
         *
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        if (! $user->isAdmin()) {
            return ResponseService::error('You are not authorized to access this route.', 403);
        }

        return $next($request);
    }
}
