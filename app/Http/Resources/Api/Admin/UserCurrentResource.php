<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCurrentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $emailVerified = $this->email_verified_at;
        $isActive = $this->is_active;
        $isSuspended = $this->is_suspended;

        if (
            ! is_null($emailVerified) &&
            $isActive &&
            ! $isSuspended
        ) {
            return [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'username' => $this->username,
                'email' => $this->email,
                'role' => $this->role,
                'verification_code' => $this->verification_code,
                'email_verified_at' => $this->email_verified_at,
                'is_active' => $this->is_active,
                'is_suspended' => $this->is_suspended,
                'is_admin' => $this->is_admin,
                'is_impersonating' => $this->is_impersonating,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,

                'profile' => [
                    'avatar' => $this->profile->avatar,
                    'gender' => $this->profile->gender,
                    'dob' => $this->profile->dob,
                    'phone' => $this->profile->phone,
                    'country_id' => $this->profile->country_id,
                    'state_id' => $this->profile->state_id,
                    'city_id' => $this->profile->city_id,
                    'zipcode' => $this->profile->zipcode,
                    'street' => $this->profile->street,
                ],

            ];
        }
    }
}
