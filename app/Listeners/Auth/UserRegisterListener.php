<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserRegisterEvent;
use Shaz3e\EmailBuilder\Services\EmailBuilderService;

class UserRegisterListener
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
    public function handle(UserRegisterEvent $event): void
    {
        $email = new EmailBuilderService;

        // $verification_link = route('auth.verification'); // use this route from routes

        $email->sendEmailByKey('verification_code', $event->user->email, [
            'app_name' => config('app.name'),
            'name' => $event->user->name,
            'code' => $event->user->verification_code,
        ]);
    }
}
