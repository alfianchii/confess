<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_nik',
        'nip',
    ];

    protected $primaryKey = 'officer_nik';

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'officer_nik', 'nik');
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'officer_nik', 'officer_nik');
    }
}
