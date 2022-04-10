<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institutions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'institutions';

    protected $fillable = [
        'url_hash',
        'name',
        'country',
        'region',
        'presbytery',
        'createuser',
    ];

    public function _presbytery()
    {
        return $this->belongsTo(Presbyteries::class, "presbytery", "id");
    }

    public function _region()
    {
        return $this->belongsTo(Regions::class, "region", "code");
    }
}
