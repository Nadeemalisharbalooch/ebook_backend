<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Admin\UpdatePassword;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $validated = $request->validated();

        //  update user table fields
        $user->update(collect($validated)->only(['name', 'email', 'username'])->toArray());

        // Profile table update
        $profile = $user->profile;
        if ($profile) {
            $profile->update(collect($validated)->except(['name', 'email', 'username'])->toArray());
        } else {
            return ResponseService::error('User profile does not exist.', 404);
        }

        return ResponseService::success(
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
}
