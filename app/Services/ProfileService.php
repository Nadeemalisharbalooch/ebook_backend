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
        $user->update($userData);

        $profileData = Arr::only($validated, [
            'gender', 'dob', 'phone', 'country_id', 'state_id', 'city_id', 'zipcode', 'address',
        ]);
        if ($avatarFile) {
            // Delete old image if exists
            if ($old = $user->profile?->avatar) {
                Storage::disk('public')->delete($old);
            }
            // Store new image
            $profileData['avatar'] = $avatarFile->store('avatars', 'public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );
    }
}
