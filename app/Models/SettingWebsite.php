<?php

namespace App\Models;

use App\Models\Traits\Flagging;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingWebsite extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes, Flagging;


    // ---------------------------------
    // PROPERTIES
    protected $table = "set_website";
    protected $primaryKey = "id_website";
    protected $guarded = [
        'id_website',
    ];
}
