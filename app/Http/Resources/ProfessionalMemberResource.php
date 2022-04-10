<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionalMemberResource extends JsonResource
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
            'title' => $this->title,
            'name' => $this->name,
            'fullName' => $this->title. ' '.$this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'group' => $this->group,
            'groupDesc' => $this->_group_name,
        ]; 
    }
}
