<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CongressMemberResource extends JsonResource
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
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'fullName' => "{$this->fname} {$this->mname} {$this->lname}",
            'phone' => $this->phone,
            'email' => $this->email,
            'union' => $this->union,
            'unionDesc' => $this->_union->name,
            'congress' => $this->congress,
            'congressDesc' => $this->_congress->description
        ]; 
    }
}
