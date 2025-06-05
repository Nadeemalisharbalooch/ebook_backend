<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ImpersonationController extends Controller
{
    public function impersonate(User $user)
    {
        // Check if current user can impersonate (e.g. is admin)
        if (! auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        // Store original user id to session
        session(['impersonate' => $user->id]);

        return response()->json([
            'message' => 'You are now impersonating '.$user->name,
            'impersonated_user' => $user,
        ]);
    }

    public function stopImpersonate()
    {
        // Remove impersonate from session
        session()->forget('impersonate');

        return redirect('/dashboard')->with('success', 'You have returned to your account.');
    }
}
