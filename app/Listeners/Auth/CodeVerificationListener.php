<?php

namespace App\Listeners\Auth;

use App\Events\Auth\CodeVerificationEvent;

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

        // Todo: Send Verification Code via Email
    }
}
