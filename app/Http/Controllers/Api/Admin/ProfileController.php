<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Admin\UpdatePassword;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function view(Request $request)
    {

        $user = $request->user()->load('profile');

        return ResponseService::success($user);
    }

    /**
     * Update the authenticated user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /** @var \App\Models\User */
public function update(ProfileUpdateRequest $request)
{
    $user = Auth::user();
    $v = $request->validated();

    // Update user fields
    $user->update($request->only(['username', 'name', 'email']));

    // Collect profile fields
    $profileData = $request->only([
      'avatar','gender','dob','phone',
      'country','state','city','zipcode','address'
    ]);

    // Handle avatar upload
    if ($file = $request->file('avatar')) {
        if ($old = $user->profile?->avatar) {
            Storage::disk('public')->delete($old);
        }
        $profileData['avatar'] = $file->store('avatars', 'public');
    }

    // Update or create profile
    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        $profileData
    );

    return ResponseService::success('Profile updated successfully');
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
}
