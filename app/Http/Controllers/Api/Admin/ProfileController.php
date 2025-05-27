<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Resources\Api\Admin\ProfileResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        return $request->user();
    }

   /*  public function store(Request $request)
    {
        // Update the user's profile
    } */


    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();

        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return ResponseService::success(
            new ProfileResource($profile),
            'Profile updated successfully'
        );
    }
}
