<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CongressResource extends JsonResource
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
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'startDate' => $this->phone,
            'endDate' => $this->email,
            "startDate" => !$this->start_date ? 'Not Scheduled' : strtoupper(date('j M, Y', strtotime($this->start_date))),
            "endDate" => !$this->start_date ? 'Not Scheduled' : strtoupper(date('j M, Y', strtotime($this->end_date))),
            "status" => $this->end_date < date('Y-m-d') ? '<span class="label bg-danger">Ended</span>' : '<span class="label bg-success">Active</span>',
        ]; 
    }
}
