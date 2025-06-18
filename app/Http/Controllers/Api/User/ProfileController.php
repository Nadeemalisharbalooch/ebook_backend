<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Http\Requests\User\updatePassword;
use App\Models\Profile;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function view(Request $request)
    {

        $user = $request->user()->load('profile');

        return ResponseService::success($user);
    }

    public function update(ProfileUpdateRequest $request)
    {
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

}
