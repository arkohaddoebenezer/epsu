<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'district' => $this->district,
            'presbyteryDesc' => $this->_district->_presbytery->name,
            'presbytery' => $this->_district->presbytery,
            'districtDesc' => $this->_district->name,
        ]; 
    }
}
