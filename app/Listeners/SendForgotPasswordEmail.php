<?php

namespace App\Listeners;

use App\Events\UserRequestedPasswordReset;

class SendForgotPasswordEmail
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
    public function handle(UserRequestedPasswordReset $event): void
    {
        //
    }
}
