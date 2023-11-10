<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterUserRole extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes;


    // ---------------------------------
    // PROPERTIES
    protected $table = 'mst_users_role';
    protected $primaryKey = 'id_user_role';
    protected $guarded = [
        'id_user_role',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function role()
    {
        return $this->belongsTo(MasterRole::class, 'id_role', 'id_role');
    }


    // ---------------------------------
    // HELPERS


    // ---------------------------------
    // UTILITIES
}
