<?php

namespace App\Models;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    /*
        Data Scheme:
            xAxis
            yAxis
    */
    public static function yourHistoryLoginAxises(User $user)
    {
        // Your history logins
        $yourHistoryLogins = HistoryLogin::where("username", $user->username)
            ->where("attempt_result", "Y")
            ->whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of history logins for each day
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy("date", "created_at")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // Create an array to store the history login counts for each day
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        // Loop through the date range and populate the counts array with the history logins counts
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

    /*
        Data Scheme:
            data
                xAxis
                yAxis
            genders
                male
                female
    */
    public static function historyLoginAxises()
    {
        // All history logins
        $historyLogins = HistoryLogin::where("attempt_result", "Y")
            ->whereBetween("history_logins.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of logins for each day
            ->selectRaw("DATE(history_logins.created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy("date")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // All logins' genders
        $genders = HistoryLogin::leftJoin("mst_users", 'history_logins.username', "=", "mst_users.username")
            ->where("attempt_result", "Y")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        // Create an array to store the all logins' data
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

        // Loop through the date range and populate the counts array with the all login counts
        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($historyLogins as $login) {
                if ($date->format("Y-m-d") == $login->date) $counts += $login->count;
            }

            $axises["data"]['yAxis'][] = $counts;
            $axises["data"]['xAxis'][] = $date->format("Y-m-d");
        }

        // Convert string to int
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

        // Filter by user
        if ($user) $query->where("username", $user->username);

        // Return the filtered results
        if (!$limit) return $query;

        // Return limited results
        return $query->limit($limit);
    }


    // ---------------------------------
    // UTILITIES
}