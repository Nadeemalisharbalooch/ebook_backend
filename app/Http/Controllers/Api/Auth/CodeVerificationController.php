<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\Auth\CodeVerificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Auth\AuthUserResource;
use App\Http\Resources\Api\Auth\LoginUserResource;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeVerificationController extends Controller
{
    public function verification(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (! $user) {
            return ResponseService::error('User not found', 404);
        }

        $otpInput = (string) $request->input('otp');
        $verificationCode = (string) $user->verification_code;

        if ($verificationCode && $verificationCode === $otpInput) {
            $user->email_verified_at = now();
            $user->is_active = true;
            $user->verification_code = null; // clear OTP
            $user->save();

            // relation load karna zaroori
            $user->load('profile');

            $resource = new LoginUserResource($user);

            return ResponseService::success(
                $resource,
                'Your code has been verified. You can now login.'
            );
        }

        return ResponseService::error('Verification code is invalid, please try again', 422);
    }



    public function resendVerificationCode(Request $request)
    {

        $user = Auth::user();

        event(new CodeVerificationEvent($user));

        return ResponseService::success('New verification code has been sent to your email.');
    }
}
