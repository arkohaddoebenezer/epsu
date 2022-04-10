<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CongressMembers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'congress_members';

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'phone',
        'email',
        'union',
        'congress',
        'createuser',
    ];

    public function _union()
    {
        return $this->belongsTo(Unions::class, "union", "id");
    }

    public function _congress()
    {
        return $this->belongsTo(Congress::class, "congress", "id");
    }
}
