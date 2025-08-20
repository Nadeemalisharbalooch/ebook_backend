<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            // user fields
            'id'               => $this->id,
            'username'         => $this->username,
            'first_name'       => $this->first_name,
            'last_name'        => $this->last_name,
            'email'            => $this->email,
            'email_verified_at'=> $this->email_verified_at,
            'verification_code'=> $this->verification_code,
            'role'             => $this->role,
            'is_accept_terms'  => $this->is_accept_terms,
            'is_admin'         => $this->is_admin,
            'is_active'        => $this->is_active,
            'is_suspended'     => $this->is_suspended,
            'is_impersonating' => $this->is_impersonating,
            'deleted_at'       => $this->deleted_at,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,

            // nested profile fields
            'profile' => $this->profile ? [
                'id'      => $this->profile->id,
                'avatar'  => $this->profile->avatar,
                'gender'  => $this->profile->gender,
                'dob'     => $this->profile->dob,
                'phone'   => $this->profile->phone,
                'zipcode' => $this->profile->zipcode,
                'street'  => $this->profile->street,

                // relations
                'country' => $this->profile->country ? [
                    'id'   => $this->profile->country->id,
                    'name' => $this->profile->country->name,
                ] : null,

                'state' => $this->profile->state ? [
                    'id'   => $this->profile->state->id,
                    'name' => $this->profile->state->name,
                ] : null,

                'city' => $this->profile->city ? [
                    'id'   => $this->profile->city->id,
                    'name' => $this->profile->city->name,
                ] : null,

            ] : null,
        ];
    }
}
