<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\Auth\CodeVerificationEvent;
use App\Events\Auth\SendWelcomeEmailEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Auth\AuthUserResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeVerificationController extends Controller
{
    public function verification(Request $request)
    {
        // Assuming the code is sent as a single input field
        $codeInput = $request->input('code');
        $user = Auth::user();

        if ($user->verification_code == $codeInput) {
            // Mark the user as verified
            $user->email_verified_at = now();
            $user->is_active = true;
            /** @var \App\Models\User $user */
            $user->save();

            event(new SendWelcomeEmailEvent($user));

            $resource = new AuthUserResource($user);

            return ResponseService::success(
                $resource,
                'Your code has been verified you can now login'
            );
        }

        return ResponseService::error('Verification code is invalid, please try again', 200);
    }

    public function resendVerificationCode(Request $request)
    {

        $user = Auth::user();

        event(new CodeVerificationEvent($user));

        return ResponseService::success('New verification code has been sent to your email.');
    }
}
