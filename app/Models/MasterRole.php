<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class MasterRole extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes;


    // ---------------------------------
    // PROPERTIES
    protected $table = "mst_roles";
    protected $primaryKey = "id_role";
    protected $guarded = [
        'id_role',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function userRole()
    {
        return $this->hasMany(MasterUserRole::class, 'id_role', 'id_role');
    }

    public function anotherUsersBasedYourRole()
    {
        return $this->hasMany(MasterUserRole::class, 'id_role', 'id_role')
            ->where("flag_active", "Y");
    }
}
