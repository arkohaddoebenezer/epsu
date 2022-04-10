<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
        'presbytery' => $this->presbytery,
        'presbyteryDesc' => $this->_presbytery->name,
        'district' => $this->district,
        'districtDesc' => $this->_district->name,
        'branch' => $this->branch,
        'branchDesc' => $this->_branch->name,
        'union' => $this->union,
        'unionDesc' => $this->_union->name,
        'member_id' => $this->member_id,
        'title' => $this->title,
        'fname' => $this->fname,
        'mname' => $this->mname,
        'lname' => $this->lname,
        'name' => "{$this->title} {$this->fname} {$this->mname} {$this->lname}",
        'gender' => $this->gender,
        'dob' => $this->dob,
        'marital_status' => $this->marital_status,
        'phone' => $this->phone,
        'email' => $this->email,
        'contact' => "{$this->phone} <br>- {$this->email}",
        'nationality' => $this->nationality,
        'hometown' => $this->hometown,
        'region' => $this->region,
        'regionDesc' => $this->_region_name,
        'member_type' => $this->member_type,
        'institution' => $this->institution,
        'institutionDesc' => $this->_institution->name ?? '',
        'programme' => $this->programme,
        'current_level' => $this->current_level,
        'academic_year' => $this->academic_yearid,
        'residence' => $this->residence,
        'room_details' => $this->room_details,
        'employment_status' => $this->employment_status,
        'profession' => $this->profession,
        'pob' => $this->pob,
        'mother_church' => $this->mother_church,
        'place_of_work' => $this->place_of_work,
        'emergency_person' => $this->emergency_person,
        'emergency_contact' => $this->emergency_contact,
        'picture' => $this->picture,
        'position' => $this->position,
        'position_year' => $this->position_year,
        'createuser' => $this->id,
        ]; 
    }
}
