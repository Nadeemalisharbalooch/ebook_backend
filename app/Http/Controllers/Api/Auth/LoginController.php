<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\AuthResource;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return ResponseService::error('Invalid email or password.', 401);
        }

        $user = Auth::user();
        // Generate token using Laravel Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return ResponseService::success(
            [
                'user' => new AuthResource($user),
                'token' => $token,
            ],
            'Login successful.'
        );
    }
}
