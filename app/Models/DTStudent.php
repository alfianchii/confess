<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class DTStudent extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes;


    // ---------------------------------
    // PROPERTIES
    protected $table = "dt_students";
    protected $primaryKey = "id_student";
    protected $guarded = [
        'id_student',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function user()
    {
        return $this->hasOne(User::class, "id_user", "id_user");
    }

    public function confessions()
    {
        return $this->hasMany(RecConfession::class, "id_user", "id_user");
    }

    public function responses()
    {
        return $this->hasMany(HistoryConfessionResponse::class, "id_user", "id_user");
    }

    public function comments()
    {
        return $this->hasMany(RecConfessionComment::class, "id_user", "id_user");
    }
}
