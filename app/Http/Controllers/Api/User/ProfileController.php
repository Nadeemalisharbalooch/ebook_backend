<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Http\Requests\User\updatePassword;
use App\Http\Resources\Api\Auth\LoginUserResource;
use App\Services\ProfileService;
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

public function update(ProfileUpdateRequest $request, ProfileService $svc)
{
    $user = $svc->update(
        Auth::user(),
        $request->only(['username', 'first_name', 'last_name', 'email']),
        $request->validated(),
        $request->file('avatar')
    );
    return ResponseService::success(
        new LoginUserResource($user),
        'Profile updated successfully'
    );
}


    public function updatePassword(UpdatePassword $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $user->update($validated);

        return ResponseService::success('Password updated successfully.');
    }
}
