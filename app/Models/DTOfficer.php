<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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


    // ---------------------------------
    // UTILITIES
}
