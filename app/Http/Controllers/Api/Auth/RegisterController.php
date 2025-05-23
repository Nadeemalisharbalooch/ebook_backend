<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\Auth\AuthResource as AuthAuthResource;
use App\Models\User;
use App\Services\ResponseService;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);

        // Return response
        return ResponseService::success(
            new AuthAuthResource($user),
            'Registration successful.'
        );
    }
}
