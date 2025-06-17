<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function impersonate(User $user)
    {
        // Only admins can impersonate
        if (! Auth::user()?->is_admin) {
            abort(403, 'Unauthorized');
        }

        // Save impersonated user ID in cache
        cache()->put('impersonate_token_'.auth()->id(), $user->id, now()->addMinutes(30));
         $user->update(['is_impersonating' => true]);

        return response()->json([
            'message' => 'Now impersonating '.$user->name,
            'impersonated_user' => $user,
        ]);
    }

  public function stopImpersonate()
{
    cache()->forget('impersonate_token_'.Auth::id());

    $userId = cache()->get('impersonated_by_'.Auth::id()); //
    if ($userId) {
        User::find($userId)?->update(['is_impersonating' => false]);
    }

    return response()->json([
        'message' => 'Impersonation stopped',
    ]);
}
}
