<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class DTOfficer extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes;


    // ---------------------------------
    // PROPERTIES
    protected $table = "dt_officers";
    protected $primaryKey = "id_officer";
    protected $guarded = [
        'id_officer',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function user()
    {
        return $this->hasOne(User::class, "id_user", "id_user");
    }

    public function confessions()
    {
        return $this->hasMany(RecConfession::class, "id_user", "assigned_to");
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
    // HELPERS
    public function scopeOfficerRoles($query)
    {
        return $query->with(["user.userRole.role"])
            ->leftJoin("mst_users_role", "mst_users_role.id_user", "=", "dt_officers.id_user")
            ->leftJoin("mst_roles", "mst_users_role.id_role", "=", "mst_roles.id_role")
            ->where("mst_users_role.flag_active", "Y")
            ->where("dt_officers.flag_active", "Y");
    }
}
