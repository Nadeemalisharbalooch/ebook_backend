<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\Auth\ResetPasswordEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Services\ResponseService;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();
        event(new ResetPasswordEvent($user));

        return ResponseService::success(null, 'Password reset token sent to your email.');
    }
}
