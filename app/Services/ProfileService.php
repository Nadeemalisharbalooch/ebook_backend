<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * Create a new class instance.
     */
   public function update(User $user, array $userData, array $validated, ?UploadedFile $avatarFile): void
{
    // Update user fields
    $user->update($userData);

    // Get profile fields from nested 'profile'
    $profileData = Arr::only($validated['profile'] ?? [], [
        'gender', 'dob', 'phone', 'country_id', 'state_id', 'city_id', 'zipcode', 'street',
    ]);

    // Handle avatar file
    if ($avatarFile) {
        if ($old = $user->profile?->avatar) {
            Storage::disk('public')->delete($old);
        }
        $profileData['avatar'] = $avatarFile->store('avatars', 'public');
    }

    // Update or create profile
    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        $profileData
    );
}

}
