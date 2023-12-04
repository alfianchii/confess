<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryConfessionLike extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory;

    // ---------------------------------
    // PROPERTIES
    protected $table = "history_confession_likes";
    protected $primaryKey = "id_confession_like";
    protected $guarded = [
        'id_confession_like',
    ];

    // ---------------------------------
    // RELATIONSHIPS
    public function confession()
    {
        return $this->belongsTo(RecConfession::class, "id_confession", "id_confession");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "id_user", "id_user");
    }
}
