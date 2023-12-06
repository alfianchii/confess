<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model};
use App\Models\Traits\{Daily};

class HistoryLogin extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, Daily;


    // ---------------------------------
    // PROPERTIES
    protected $table = 'history_logins';
    protected $primaryKey = 'id_history_login';
    protected $guarded = [
        'id_history_login',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class, "username", "username");
    }


    // ---------------------------------
    // HELPERS
    public static function yourHistoryLoginAxises(User $user)
    {
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        $yourHistoryLogins = HistoryLogin::where("username", $user->username)
            ->where("attempt_result", "Y")
            ->whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy("date", "created_at")
            ->oldest("date")
            ->get();

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($yourHistoryLogins as $login) {
                if ($date->format("Y-m-d") == $login->date) $counts += $login->count;
            }

            $axises['yAxis'][] = $counts;
            $axises['xAxis'][] = $date->format("Y-m-d");
        }

        return $axises;
    }

    public static function historyLoginAxises()
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

        $historyLogins = HistoryLogin::where("attempt_result", "Y")
            ->whereBetween("history_logins.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(history_logins.created_at) as date, COUNT(*) as count")
            ->groupBy("date")
            ->oldest("date")
            ->get();

        $genders = HistoryLogin::leftJoin("mst_users", 'history_logins.username', "=", "mst_users.username")
            ->where("attempt_result", "Y")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($historyLogins as $login) {
                if ($date->format("Y-m-d") == $login->date) $counts += $login->count;
            }

            $axises["data"]['yAxis'][] = $counts;
            $axises["data"]['xAxis'][] = $date->format("Y-m-d");
        }

        foreach ($genders as $key => $value) {
            $axises['genders'][$key] = (int) $value;
        }

        return $axises;
    }

    public static function scopeRecentHistoryLogins($query, int $limit = null, User $user = null)
    {
        $query->select("history_logins.*")
            ->latest()
            ->where("attempt_result", "Y");

        if ($user) $query->where("username", $user->username);

        if (!$limit) return $query;

        return $query->limit($limit);
    }
}