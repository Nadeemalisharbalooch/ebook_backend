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
    return $request->all();
    $user = Auth::user();
    $validated = $request->validated();

    $user->update(
        collect($validated)->only(['username', 'name', 'email'])->toArray()
    );
    $profileData = $validated['profile'] ?? [];

    if ($request->hasFile('avatar')) {
        // Delete old avatar if exists
        if ($user->profile && $user->profile->avatar) {
            Storage::delete('public/' . $user->profile->avatar);
        }

        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $profileData['avatar'] = $avatarPath;
    }

    if (!empty($profileData)) {
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );
    }

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
