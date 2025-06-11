<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\GenericTemplateMail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use Shaz3e\EmailBuilder\Services\EmailBuilderService;


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
        $email = new EmailBuilderService;
        $email->sendEmailBykey('welcome_email', "nadeemalisharbalooch@gmail.com", [
            'app_name' => config('app.name'),
            'name' => $event->user->name,
            'app_url' => config('app.url'),
        ]);
    }
}
