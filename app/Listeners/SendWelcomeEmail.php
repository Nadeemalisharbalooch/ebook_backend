<?php

namespace App\Listeners;

use App\Events\UserRegistered;

class SendWelcomeEmail
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
    public function handle(UserRegistered $event): void
    {

        $verificationUrl = config('app.url').'/verify/'.$event->user->id;

        $email = new \App\Services\EmailBuilderService;
        $email->sendEmailBykey('welcome_email', 'nadeemalisharbalooch@gmail.com', [
            'name' => $event->user->name,
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'verification_url' => $verificationUrl,
        ]);
    }
}
