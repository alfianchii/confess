<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    // protected $with = [
    //     'officer',
    //     'complaint',
    // ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class, 'officer_nik', 'officer_nik');
    }
}
