<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    // ---------------------------------
    // TRAITS
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    // ---------------------------------
    // PROPERTIES
    protected $table = 'mst_users';
    protected $primaryKey = 'id_user';
    protected $guarded = [
        'id_user',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function officer()
    {
        return $this->hasOne(DTOfficer::class, 'id_user', 'id_user');
    }

    public function student()
    {
        return $this->hasOne(DTStudent::class, 'id_user', 'id_user');
    }

    public function userRole()
    {
        return $this->hasOne(MasterUserRole::class, "id_user", "id_user");
    }

    public function responses()
    {
        return $this->hasMany(HistoryConfessionResponse::class, "id_user", "id_user");
    }

    public function comments()
    {
        return $this->hasMany(RecConfessionComment::class, "id_user", "id_user");
    }


    // ---------------------------------
    // UTILITIES
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRouteKeyName()
    {
        return "username";
    }
}
