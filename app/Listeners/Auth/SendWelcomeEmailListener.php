<?php

namespace App\Listeners\Auth;

use App\Events\Auth\SendWelcomeEmailEvent;
use Shaz3e\EmailBuilder\Services\EmailBuilderService;

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

        $email = new EmailBuilderService;
        $email->sendEmailByKey('welcome_email', $user->email, [
            'name' => $user->name,
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
        ]);
    }
}
