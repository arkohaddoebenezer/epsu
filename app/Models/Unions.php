<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'unions';

    protected $fillable = [
        'url_hash',
        'name',
        'branch',
        'createuser',
    ];

    public function _branch()
    {
        return $this->belongsTo(Branches::class, "branch", "id");
    }
}
