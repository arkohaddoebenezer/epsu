<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Districts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'districts';

    protected $fillable = [
        'url_hash',
        'name',
        'presbytery',
        'createuser',
    ];

    public function _presbytery()
    {
        return $this->belongsTo(Presbyteries::class, "presbytery", "id");
    }

    public function children()
    {
       return $this->hasMany(Branches::class,'district','id');
    }
}
