<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Http\Requests\User\updatePassword;
use App\Models\Profile;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

}
