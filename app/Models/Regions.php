<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'regions';

    protected $fillable = [
        'country',
        'code',
        'desc',
    ];
}
