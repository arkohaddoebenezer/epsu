<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExecutivesResource extends JsonResource
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
            'phone' => $this->phone,
            'email' => $this->email,
            'position' => $this->position,
            'contact' => $this->phone .'<br>-' .$this->email,
            "startDate" => empty($this->start_date) ? 'Not Set' : strtoupper(date('j M, Y', strtotime($this->start_date))),
            "endDate" =>empty(!$this->start_date) ? 'Not Set' : strtoupper(date('j M, Y', strtotime($this->end_date))),
            "statusDesc" => $this->status==1 ? '<span class="label bg-danger">Inactive</span>' : '<span class="label bg-success">Active</span>',
            'status' => $this->status,
        ]; 
    }
}
