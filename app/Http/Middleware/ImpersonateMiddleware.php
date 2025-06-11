<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $originalUserId = Auth::id(); // Logged-in user's ID (via token)

        // Check cache if impersonation is active
        $impersonatedUserId = cache()->get('impersonate_token_'.$originalUserId);

        if ($impersonatedUserId) {
            $impersonatedUser = User::find($impersonatedUserId);
            if ($impersonatedUser) {
                Auth::setUser($impersonatedUser); // Override auth()->user()
            }
        }

        return $next($request);
    }
}
