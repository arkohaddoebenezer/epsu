<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Councils extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'council';

    protected $fillable = [
        'title',
        'name',
        'phone',
        'email',
        'position',
        'start_date',
        'end_date',
        'status',
    ];
}
