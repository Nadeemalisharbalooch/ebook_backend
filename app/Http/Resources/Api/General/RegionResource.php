<?php

namespace App\Http\Resources\Api\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'translations' => $this->translations,
            'flag'         => $this->flag,
            'wikiDataId'   => $this->wikiDataId,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
