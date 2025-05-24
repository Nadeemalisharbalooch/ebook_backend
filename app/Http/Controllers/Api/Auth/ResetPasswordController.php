<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        $password = $request->input('password');

        // Fetch password reset record by email
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record || $record->token !== $token) {
            return ResponseService::error('Invalid token or email', 400);
        }

        // Update user's password
        $user = User::where('email', $email)->first();
        if (! $user) {
            return ResponseService::error('User not found', 404);
        }

        $user->password = $password;
        $user->save();

        // Delete the token from password_reset_tokens table
        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();

        return ResponseService::success(null, 'Password has been reset successfully.');
    }
}
