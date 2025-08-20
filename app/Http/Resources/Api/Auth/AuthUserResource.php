<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
public function toArray(Request $request): array
{
   /*  $token = $this->createToken($this->email)->plainTextToken; */

    return [
        'id' => $this->id,
        'username' => $this->username,
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'email' => $this->email,
        'email_verified_at' => $this->email_verified_at,
        'is_active' => $this->is_active,
        'is_suspended' => $this->is_suspended,
        'is_admin' => $this->is_admin,
        'is_accept_terms' => $this->is_accept_terms,
        'role' => $this->role,

        /* 'type' => 'Bearer',
        'token' => $token, */

        'profile' => $this->whenLoaded('profile', function () {
            return [
                'avatar'     => $this->profile->avatar,
                'gender'     => $this->profile->gender,
                'dob'        => $this->profile->dob,
                'phone'      => $this->profile->phone,
                'country_id' => $this->profile->country_id,
                'state_id'   => $this->profile->state_id,
                'city_id'    => $this->profile->city_id,
                'zipcode'    => $this->profile->zipcode,
                'street'     => $this->profile->street,
            ];
        }),
    ];
}
}
