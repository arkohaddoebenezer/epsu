<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalMembers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'professional_members';

    protected $fillable = [
        'title',
        'name',
        'phone',
        'email',
        'group',
        'createuser',
    ];

    public function _group()
    {
        return $this->belongsTo(ProfessionalGroups::class, "group", "id");
    }
}
