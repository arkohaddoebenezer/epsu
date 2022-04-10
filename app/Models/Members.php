<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Members extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'members';

    protected $fillable = [
        'url_hash',
        'presbytery',
        'district',
        'branch',
        'union',
        'member_id',
        'title',
        'fname',
        'mname',
        'lname',
        'gender',
        'dob',
        'marital_status',
        'phone',
        'email',
        'nationality',
        'hometown',
        'region',
        'member_type',
        'institution',
        'programme',
        'current_level',
        'academic_year',
        'residence',
        'room_details',
        'employment_status',
        'profession',
        'pob',
        'mother_church',
        'place_of_work',
        'emergency_person',
        'emergency_contact',
        'picture',
        'position',
        'position_year',
        'createuser',
    ];

    public function _presbytery()
    {
        return $this->belongsTo(Presbyteries::class, "presbytery", "id");
    }

    public function _district()
    {
        return $this->belongsTo(Districts::class, "district", "id");
    }

    public function _branch()
    {
        return $this->belongsTo(Branches::class, "branch", "id");
    }

    public function _union()
    {
        return $this->belongsTo(Unions::class, "union", "id");
    }

    public function _institution()
    {
        return $this->belongsTo(Institutions::class, "institution", "id");
    }
}
