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
        $user = $this;

        return [
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,

            'profile' => [
                'avatar' => $user->profile->avatar,
                'gender' => $user->profile->gender,
                'dob' => $user->profile->dob,
                'phone' => $user->profile->phone,
                'country' => $user->profile->country,
                'state' => $user->profile->state,
                'city' => $user->profile->city,
                'zipcode' => $user->profile->zipcode,
                'address' => $user->profile->address,
            ],

            // Flat lists, no nesting
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getPermissionsViaRoles()->pluck('name'),
        ];
    }
}
