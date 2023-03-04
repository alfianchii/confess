<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_nik',
        'nisn',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "nik");
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, "student_nik");
    }
}
