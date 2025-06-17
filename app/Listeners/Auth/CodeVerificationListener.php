<?php

namespace App\Listeners\Auth;

use App\Events\Auth\CodeVerificationEvent;
use Shaz3e\EmailBuilder\Services\EmailBuilderService;

class CodeVerificationListener
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
    public function handle(CodeVerificationEvent $event): void
    {
        $user = $event->user;

        $email = new EmailBuilderService;
        $email->sendEmailByKey('code_verification', $user->email, [
            'name' => $user->name,
            'verification_code' => $user->verification_code,
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
        ]);
    }
}
