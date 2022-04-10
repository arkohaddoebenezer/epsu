<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Executives extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'national_executives';

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
