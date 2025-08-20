<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

       public function toArray($request)
    {
        return [
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

            // nested profile
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'country'   => $this->whenLoaded('country'),
            'state'     => $this->whenLoaded('state'),
            'city'      => $this->whenLoaded('city'),
        ];
    }
}
