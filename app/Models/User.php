<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'usertype',
        'presbytery',
        'district',
        'branch',
        'union',
        'picture',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function _presbytery()
    {
        return $this->belongsTo(Presbyteries::class, "presbytery", "id");
    }

    public function _district()
    {
        return $this->belongsTo(Districts::class, "district", "id");
    }

    public function _branch()
    {
        return $this->belongsTo(Branches::class, "branch", "id");
    }

    public function _union()
    {
        return $this->belongsTo(Unions::class, "union", "id");
    }
}
