<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presbyteries extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'presbyteries';

    protected $fillable = [
        'url_hash',
        'name',
        'createuser',
    ];

    public function children()
    {
       return $this->hasMany(Districts::class,'presbytery','id');
    }
}
