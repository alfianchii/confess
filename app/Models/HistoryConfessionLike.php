<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model};

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


    // ---------------------------------
    // HELPERS
    public static function yourConfessionLikeAxises(User $user)
    {
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        $yourConfessionLikes = HistoryConfessionLike::where("id_user", $user->id_user)
            ->whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy("date", "created_at")
            ->oldest("date")
            ->get();

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($yourConfessionLikes as $like) {
                if ($date->format("Y-m-d") == $like->date) $counts += $like->count;
            }

            $axises['yAxis'][] = $counts;
            $axises['xAxis'][] = $date->format("Y-m-d");
        }

        return $axises;
    }

    public static function confessionLikeAxises()
    {
        $axises = [
            "data" => [
                'xAxis' => [],
                'yAxis' => [],
            ],
            "genders" => [
                'male' => 0,
                'female' => 0,
            ],
        ];

        $confessions = HistoryConfessionLike::whereBetween("history_confession_likes.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(history_confession_likes.created_at) as date, COUNT(*) as count")
            ->groupBy("date", "history_confession_likes.created_at")
            ->oldest("date")
            ->get();

        $genders = HistoryConfessionLike::leftJoin("mst_users", "history_confession_likes.id_user", "=", "mst_users.id_user")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($confessions as $confession) {
                if ($date->format("Y-m-d") == $confession->date) $counts += $confession->count;
            }

            $axises['data']['yAxis'][] = $counts;
            $axises['data']['xAxis'][] = $date->format("Y-m-d");
        }

        foreach ($genders as $key => $value) {
            $axises['genders'][$key] = (int) $value;
        }

        return $axises;
    }
}
