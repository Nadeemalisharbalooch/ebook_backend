<?php

namespace App\Listeners\Auth;

use App\Events\Auth\ResetPasswordEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Shaz3e\EmailBuilder\Services\EmailBuilderService;

class ResetPasswordListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ResetPasswordEvent $event): void
    {
        $user = $event->user;

        $token = Str::random(64);
        $now = Carbon::now();

        // Insert or update the token in password_resets table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => $now,
            ]
        );

        $url = config('app.front_end').'/reset-password?token='.$token.'&email='.urlencode($user->email);

        $email = new EmailBuilderService;
        $email->sendEmailByKey('reset_password', $user->email, [
            'name' => $user->name,
            'reset_url' => $url,
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
        ]);
    }
}
