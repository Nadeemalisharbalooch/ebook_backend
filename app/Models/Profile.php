<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',
        'gender',
        'dob',
        'phone',
        'country',
        'state',
        'city',
        'zipcode',
        'address',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',         // Date of birth
        ];
    }

    /**
     * Get the available gender types.
     *
     * This method returns an array of gender types that can be used
     * in the application. The available options are:
     * - Male
     * - Female
     * - Other
     *
     * @return array The available gender types.
     */
    public static function getGenderTypes(): array
    {
        return [
            'Male' => 'Male',
            'Female' => 'Female',
            'Other' => 'Other',
        ];
    }

    public function getPhoneAttribute($value)
    {
        // Return empty if the value is null or empty
        if (empty($value)) {
            return '';
        }

        // Step 1: Remove spaces and all non-numeric characters except +
        $phone = preg_replace('/[^\d+]/', '', $value);

        // Step 2: Ensure it starts with a single + at the start
        $phone = preg_replace('/^\++/', '', $phone); // Remove multiple + signs
        $phone = '+'.$phone;

        return $phone;
    }

    /**
     * The user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
