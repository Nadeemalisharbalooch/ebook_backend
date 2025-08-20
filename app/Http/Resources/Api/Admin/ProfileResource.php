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
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'avatar'    => $this->avatar,
            'gender'    => $this->gender,
            'dob'       => $this->dob,
            'phone'     => $this->phone,
            'zipcode'   => $this->zipcode,
            'street'    => $this->street,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,

            // Relations
            'country'   => $this->whenLoaded('country'),
            'state'     => $this->whenLoaded('state'),
            'city'      => $this->whenLoaded('city'),
        ];
    }
}
