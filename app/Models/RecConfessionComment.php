<?php

namespace App\Models;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function PHPUnit\Framework\isEmpty;

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

    public static function setComment(User $user, RecConfession $confession, $comment = null, string $privacy, $params = [])
    {
        // Response
        $commentFields = [
            "id_confession" => $confession->id_confession,
            "id_user" => $user["id_user"],
            "comment" => $comment,
            "privacy" => $privacy,
            "created_by" => $user["full_name"],
        ];

        // Set another field
        if (isEmpty($params)) {
            foreach ($params as $key => $value) {
                $commentFields[$key] = $value;
            }
        };

        return RecConfessionComment::create($commentFields);
    }

    // Populate the data based on the per page
    public function scopePaginateCommentsFromConfession($query, int $perPage)
    {
        return $query
            ->with(["confession.comments"])
            ->get()
            ->each(function ($comment) use ($perPage) {
                // Get the confession's comments
                $commentsFromConfession = $comment->confession->comments;

                // Take the sum of confession's comments
                $total = $commentsFromConfession->count();
                // Take the page numbers for the pagination's number
                $pageNumbers = (int) ceil($total / $perPage);

                // Slice the comments based on the $perPage
                $confessionComments = [];
                // If more than $perPage (more than 1 page)
                if ($total >= $perPage)
                    for ($index = 0; $index < $pageNumbers; $index++)
                        $confessionComments[] = $commentsFromConfession
                            ->skip($index * $perPage)
                            ->take($perPage)
                            ->all();
                // If less than $perPage (1 page)
                else
                    $confessionComments[] = $commentsFromConfession->all();

                foreach ($confessionComments as $items_index => $items) {
                    // Set the page
                    $page = $items_index + 1;

                    foreach ($items as $item)
                        // Regist the comment's page to eachcomment 
                        if ($item->id_confession_comment === $comment->id_confession_comment)
                            $comment->page = $page;
                }
            });
    }


    // ---------------------------------
    // UTILITIES
}
