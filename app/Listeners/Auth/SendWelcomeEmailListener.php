<?php

namespace App\Listeners\Auth;

use App\Events\Auth\SendWelcomeEmailEvent;

class SendWelcomeEmailListener
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
    public function handle(SendWelcomeEmailEvent $event): void
    {
        $user = $event->user;

        // Todo: Send Welcome Email
    }
}
