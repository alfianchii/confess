<?php

namespace App\Models;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecConfessionComment extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes, Daily;


    // ---------------------------------
    // PROPERTIES
    protected $table = "rec_confession_comments";
    protected $primaryKey = "id_confession_comment";
    protected $guarded = [
        'id_confession_comment',
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

    public function student()
    {
        return $this->belongsTo(DTStudent::class, "id_user", "id_user");
    }

    public function officer()
    {
        return $this->belongsTo(DTOfficer::class, "id_user", "id_user");
    }


    // ---------------------------------
    // HELPERS
    /*
        Data Scheme:
            xAxis
            yAxis
    */
    public static function yourCommentAxises(User $user)
    {
        // Your comments
        $yourComments = RecConfessionComment::where("id_user", $user->id_user)
            ->whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of comments for each day
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy("date", "created_at")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // Create an array to store the comment counts for each day
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        // Loop through the date range and populate the counts array with the comments counts
        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($yourComments as $comment) {
                if ($date->format("Y-m-d") == $comment->date) $counts += $comment->count;
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
    public static function commentAxises()
    {
        // All Comments
        $comments = RecConfessionComment::whereBetween("rec_confession_comments.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of comments for each day
            ->selectRaw("DATE(rec_confession_comments.created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy("date")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // All comments' genders
        $genders = RecConfessionComment::leftJoin("dt_officers", "rec_confession_comments.id_user", "=", "dt_officers.id_user")
            ->leftJoin("mst_users", 'dt_officers.id_user', "=", "mst_users.id_user")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        // Create an array to store the all comments' data
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

        // Loop through the date range and populate the counts array with the all comment counts
        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($comments as $comment) {
                if ($date->format("Y-m-d") == $comment->date) $counts += $comment->count;
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


    // ---------------------------------
    // UTILITIES
}
