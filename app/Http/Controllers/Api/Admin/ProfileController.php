<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Admin\UpdatePassword;
use App\Http\Resources\Api\Admin\ProfileResource;
use App\Http\Resources\Api\Auth\AuthUserResource;
use App\Services\ProfileService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{


public function view(Request $request)
{
    $user = $request->user()->load([
        'profile.country',
        'profile.state',
        'profile.city',
    ]);

    return ResponseService::success(new ProfileResource($user));
}


    /**
     * Update the authenticated user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /** @var \App\Models\User */
  public function update(ProfileUpdateRequest $request, ProfileService $svc)
{
    $user = Auth::user();
    $user->load('profile'); // Ensure profile is loaded

    $svc->update(
        $user,
        $request->only(['username', 'first_name', 'last_name', 'email']),
        $request->validated(),
        $request->file('avatar')
    );

    // Refresh to make sure we have latest data (esp. avatar changes)
    $user->refresh();

    $resource = new AuthUserResource($user);

    return ResponseService::success(
        $resource,
        'Profile updated successfully'
    );
}


    /**
     * Update the authenticated user's password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePassword $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $user->update($validated);

        return ResponseService::success('Password updated successfully.');
    }

    // UserController.php

public function destroy(Request $request)
{
    $user = Auth::user();

    if (! $user) {
        return ResponseService::error('User not authenticated', 401);
    }

    // Soft delete user
    $user->delete();

    // Optionally: logout / revoke token (agar Passport/Sanctum use kar rahe ho)
    Auth::logout();

    return ResponseService::success(
        null,
        'Your account has been deleted successfully.'
    );
}

}
