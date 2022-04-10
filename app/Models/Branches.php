<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branches extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'url_hash',
        'name',
        'district',
        'createuser',
    ];

    public function _district()
    {
        return $this->belongsTo(Districts::class, "district", "id");
    }

    public function children()
    {
       return $this->hasMany(Unions::class,'branch','id');
    }
}
