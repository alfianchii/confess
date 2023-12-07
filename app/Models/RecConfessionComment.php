<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Models\Traits\{Daily, Setable};
use App\Models\Traits\Helpers\{Commentable};

class RecConfessionComment extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes, Daily, Commentable, Setable;


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
    public static function yourCommentAxises(User $user)
    {
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        $yourComments = RecConfessionComment::where("id_user", $user->id_user)
            ->whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy("date", "created_at")
            ->oldest("date")
            ->get();

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

    public static function commentAxises()
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

        $comments = RecConfessionComment::whereBetween("rec_confession_comments.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(rec_confession_comments.created_at) as date, COUNT(*) as count")
            ->groupBy("date")
            ->oldest("date")
            ->get();

        $genders = RecConfessionComment::leftJoin("dt_officers", "rec_confession_comments.id_user", "=", "dt_officers.id_user")
            ->leftJoin("mst_users", 'dt_officers.id_user', "=", "mst_users.id_user")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($comments as $comment) {
                if ($date->format("Y-m-d") == $comment->date) $counts += $comment->count;
            }

            $axises["data"]['yAxis'][] = $counts;
            $axises["data"]['xAxis'][] = $date->format("Y-m-d");
        }

        foreach ($genders as $key => $value) {
            $axises['genders'][$key] = (int) $value;
        }

        return $axises;
    }

    public static function setComment(User $user, RecConfession $confession, $comment = null, string $privacy, $params = [])
    {
        $fields = self::getCommentFields($user, $confession, $comment, $privacy);
        if (!empty($params)) $fields = self::setOtherFields($fields, $params);
        return RecConfessionComment::create($fields);
    }

    public function scopePaginateCommentsFromConfession($query, int $perPage)
    {
        return $query
            ->with(["confession.comments"])
            ->get()
            ->each(function ($comment) use ($perPage) {
                $confessionComments = $comment->confession->comments;
                $total = $confessionComments->count();
                $pageNumbers = (int) ceil($total / $perPage);

                $pagedComments = $this->getPagedConfessionComments($total, $perPage, $pageNumbers, $confessionComments);
                $comment->page = $this->setCommentPage($pagedComments, $comment);
            });
    }
}
