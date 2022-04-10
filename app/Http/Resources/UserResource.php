<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "role" => $this->usertype,
            "phone" => $this->phone,
            "presbytery" => $this->presbytery,
            "district" => $this->district,
            "branch" => $this->branch,
            "union" => $this->union,
            "picture" => $this->picture,
            "presbyteryDesc" => $this->_presby->name ?? '',
            "districtDesc" => $this->_district->name ?? '',
            "branchDesc" => $this->_branch->name ?? '',
            "unionDesc" => $this->_union->name ?? '',
        ];
    }
}
