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
    // User ke basic data update karo
    $user->update($userData);

    // Profile ke fields le lo
    $profileData = Arr::only($validated['profile'] ?? [], [
        'gender', 'dob', 'phone', 'country_id', 'state_id', 'city_id', 'zipcode', 'street',
    ]);

    // Agar avatar file upload hui hai toh
    if ($avatarFile) {
        // Purana avatar delete karo agar hai
        if ($old = $user->profile?->avatar) {
            Storage::disk('public')->delete($old);
        }

        // Naya avatar upload karo aur uska path save karo
        $profileData['avatar'] = $avatarFile->store('avatars', 'public');
    }

    // Profile update ya create karo
    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        $profileData
    );
}


}
