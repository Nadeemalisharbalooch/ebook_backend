<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class PasswordVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * This middleware protects specific routes by requiring the user to re-enter their password.
     * It verifies the provided password against the authenticated user's stored password.
     * If verification fails or password is missing, it returns an unauthorized error response.
     *
     * Usage:
     * Apply this middleware to routes where sensitive actions require password confirmation.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return ResponseService::error('Unauthorized.', 401);
        }

        $password = $request->input('password');

        if (! $password) {
            return ResponseService::error('Password is required for verification.', 401);
        }

        if (! Hash::check($password, $user->password)) {
            return ResponseService::error('Password verification failed.', 401);
        }

        return $next($request);
    }
}
