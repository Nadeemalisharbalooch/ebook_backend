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
                'username' => $this->username,
                'name' => $this->name,
                'email' => $this->email,
                'code' => $this->verification_code,
                'email_verified_at' => $this->email_verified_at,
                'is_active' => $this->is_active,
                'is_suspended' => $this->is_suspended,
                'is_locked' => $this->is_locked,
                'is_admin' => $this->is_admin,
                'is_impersonating' => $this->is_impersonating,
                'created_at' => $this->created_at,

                'profile' => [
                    'avatar' => $this->profile->avatar,
                    'gender' => $this->profile->gender,
                    'dob' => $this->profile->dob,
                    'phone' => $this->profile->phone,
                    'country' => $this->profile->country,
                    'state' => $this->profile->state,
                    'city' => $this->profile->city,
                    'zipcode' => $this->profile->zipcode,
                    'address' => $this->profile->address,
                ],

                // Flat lists, no nesting
                'roles' => $this->getRoleNames(),
                'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            ];
        }
    }
}
