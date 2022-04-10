<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'messages';

    protected $fillable = [
        'recipients',
        'type',
        'subject',
        'details',
        'createuser',
    ];
}
