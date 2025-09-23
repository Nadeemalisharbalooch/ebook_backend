<?php

namespace App\Http\Resources\Api\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'iso2'          => $this->iso2,
            'iso3'          => $this->iso3,
            'phonecode'     => $this->phonecode,
            'capital'       => $this->capital,
            'currency'      => $this->currency,
            'currency_name' => $this->currency_name,
            'region'        => $this->region,
            'subregion'     => new SubregionResource($this->whenLoaded('subregion')),
            'states'        => StateResource::collection($this->whenLoaded('states')),
        ];
    }
}
