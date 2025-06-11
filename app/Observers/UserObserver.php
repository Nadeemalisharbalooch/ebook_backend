<?php

namespace App\Observers;

use App\Events\UserRegistered;
use App\Models\User;
use Shaz3e\EmailBuilder\Services\EmailBuilderService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Create Profile with a random avatar
        $user->profile()->firstOrCreate([
            'user_id' => $user->id,
        ], [
            'avatar' => $this->randomAvatar(), // Assign a random avatar
        ]);

        // create random username
        $user->username = 'user'.$user->id;
        $user->saveQuietly();

        // Send Welcome Email
        $email = new EmailBuilderService;
        $user = User::findOrFail($user->id);

       /*  $verification_link = route('auth.verification'); */

       /*  $email->sendEmailByKey('welcome_email', 'nadeemalisharbalooch@gmail.com', [
            'name' => $user->name,
            'url' => $verification_link,
            'app_name' => config('app.name'), */
       /*  ]); */

       event(new UserRegistered($user));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }

    /**
     * Generate a random avatar path.
     */
    private function randomAvatar(): string
    {
        // Generate a random avatar number between 1 and 15
        $avatarNumber = rand(1, 15);

        // Return the avatar path
        return 'avatars/avatar'.$avatarNumber.'.jpg';
    }
}
