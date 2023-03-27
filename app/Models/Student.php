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

    protected $primaryKey = 'student_nik';

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_nik', 'nik');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'student_nik', 'student_nik');
    }
}
