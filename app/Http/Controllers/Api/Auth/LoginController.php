<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\AuthUserResource;
use App\Http\Resources\Api\Auth\LoginUserResource;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return ResponseService::error('Invalid credentials', 401);
        }

        $user = Auth::user();

        $statusError = $user->checkStatus();
        if ($statusError !== null) {
            return ResponseService::error($statusError, 403);
        }

        /** @var \App\Models\User $user */

         $resource = new LoginUserResource($user);
        return ResponseService::success([
            'user' => $resource,
        ], 'Login successful');
    }
}
