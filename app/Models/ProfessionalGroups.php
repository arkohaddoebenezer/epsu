<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalGroups extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'professional_groups';

    protected $fillable = [
        'url_hash',
        'name',
        'createuser',
    ];
}
