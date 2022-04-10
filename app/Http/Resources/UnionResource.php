<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnionResource extends JsonResource
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
            'branch' => $this->branch,
            'branchDesc' => $this->_branch->name,
            'presbyteryDesc' => $this->_branch->_district->_presbytery->name,
            'presbytery' => $this->_branch->_district->presbytery,
            'districtDesc' => $this->_branch->_district->name,
            'district' => $this->_branch->district,
        ]; 
    }
}
