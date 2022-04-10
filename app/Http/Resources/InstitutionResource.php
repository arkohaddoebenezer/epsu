<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url_hash' => $this->url_hash,
            'name' => $this->name,
            'country' => $this->country,
            'region' => $this->region,
            'regionDesc' => $this->_region->desc,
            "presbytery" => $this->presbytery,
            "presbyteryDesc" => $this->_presbytery->name
        ]; 
    }
}
