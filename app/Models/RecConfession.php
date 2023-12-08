<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Traits\{Daily};

class RecConfession extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes, Sluggable, Daily;


    // ---------------------------------
    // PROPERTIES
    protected $table = "rec_confessions";
    protected $primaryKey = "id_confession";
    protected $guarded = [
        'id_confession',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function category()
    {
        return $this->belongsTo(MasterConfessionCategory::class, "id_confession_category", "id_confession_category");
    }

    public function student()
    {
        return $this->belongsTo(DTStudent::class, "id_user", "id_user");
    }

    public function officer()
    {
        return $this->belongsTo(DTOfficer::class, "assigned_to", "id_user");
    }

    public function responses()
    {
        return $this->hasMany(HistoryConfessionResponse::class, "id_confession", "id_confession")
            ->latest();
    }

    public function comments()
    {
        return $this->hasMany(RecConfessionComment::class, "id_confession", "id_confession")
            ->latest();
    }

    public function likes()
    {
        return $this->hasMany(HistoryConfessionLike::class, "id_confession", "id_confession");
    }


    // ---------------------------------
    // HELPERS
    public static function yourConfessionAxises(User $user)
    {
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        $yourConfessions = RecConfession::where("id_user", $user->id_user)
            ->whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy("date", "created_at")
            ->oldest("date")
            ->get();

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($yourConfessions as $confession) {
                if ($date->format("Y-m-d") == $confession->date) $counts += $confession->count;
            }

            $axises['yAxis'][] = $counts;
            $axises['xAxis'][] = $date->format("Y-m-d");
        }

        return $axises;
    }

    public static function confessionAxises()
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

        $confessions = RecConfession::whereBetween("rec_confessions.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(rec_confessions.created_at) as date, COUNT(*) as count")
            ->groupBy("date", "rec_confessions.created_at")
            ->oldest("date")
            ->get();

        $genders = RecConfession::leftJoin("dt_students", "rec_confessions.id_user", "=", "dt_students.id_user")
            ->leftJoin("mst_users", "dt_students.id_user", "=", "mst_users.id_user")
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

    public static function scopeRecentConfessions($query, int $limit = null, User $user = null)
    {
        $query->with(['student.user.userRole.role', "category", 'responses'])
            ->select("rec_confessions.*")
            ->leftJoin("mst_users", "rec_confessions.id_user", "=", "mst_users.id_user")
            ->where("status", "!=", 'close')
            ->latest();

        if ($user) $query->where("rec_confessions.id_user", $user->id_user);

        if (!$limit) return $query;

        return $query->limit($limit);
    }

    public function scopeFilter($query, array $filters)
    {
        /* SEARCH: CONFESSION AND USER */
        if (isset($filters["search"]) && isset($filters["user"])) {
            return $query->with("student")->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->whereHas(
                    "student",
                    fn ($query) =>
                    $query->with("student")->whereHas(
                        "user",
                        fn ($query) =>
                        $query->with("user")->where("username", $filters["user"])
                            ->where('privacy', 'public')
                    )
                );
        }

        /* SEARCH: CONFESSION AND CATEGORY */
        if (isset($filters["search"]) && isset($filters["category"])) {
            return $query->with("category")->where(
                fn ($query) =>
                $query->with("category")->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->whereHas(
                    "category",
                    fn ($query) =>
                    $query->with("confession")->where("slug", $filters["category"])
                );
        }

        /* SEARCH: CONFESSION AND STATUS */
        if (isset($filters["search"]) && isset($filters["status"])) {
            return $query->with("student")->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->where('status', $filters["status"]);
        }

        /* SEARCH: CONFESSION AND PRIVACY */
        if (isset($filters["search"]) && isset($filters["privacy"])) {
            return $query->with("student")->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->whereHas(
                    "student",
                    fn ($query) =>
                    $query->with("student")->whereHas(
                        "confessions",
                        fn ($query) =>
                        $query->with("confessions")->where("privacy", $filters["privacy"])
                    )
                );
        }

        /* SEARCH: CONFESSION */
        $query->when(
            $filters["search"] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $search . "%")
                    ->orWhere("body", "like", "%" . $search . "%")
            )
        );

        /* SEARCH: USER */
        $query->when(
            $filters["user"] ?? false,
            fn ($query, $user) =>
            $query->whereHas(
                "student",
                fn ($query) =>
                $query->with("user")->whereHas(
                    "user",
                    fn ($query) =>
                    $query->where("username", $user)
                        ->where('privacy', 'public')
                )
            )
        );

        /* SEARCH: CATEGORY */
        $query->when(
            $filters["category"] ?? false,
            fn ($query, $category) =>
            $query->whereHas(
                "category",
                fn ($query) =>
                $query->where("slug", $category)
            )
        );

        /* SEARCH: STATUS */
        $query->when(
            $filters["status"] ?? false,
            fn ($query, $status) =>
            $query->where("status", $status)
        );

        /* SEARCH: PRIVACY */
        $query->when(
            $filters["privacy"] ?? false,
            fn ($query, $privacy) =>
            $query->where("privacy", $privacy)
        );
    }

    public function scopeIsLiked($query, User $user)
    {
        return $query->addSelect([
            'is_liked' => HistoryConfessionLike::select('id_user')
                ->whereColumn('history_confession_likes.id_confession', 'rec_confessions.id_confession')
                ->where('id_user', $user->id_user)
                ->limit(1),
            "total_likes" => HistoryConfessionLike::selectRaw("COUNT(*)")
                ->whereColumn('history_confession_likes.id_confession', 'rec_confessions.id_confession')
        ])->withCasts(['is_liked' => 'boolean']);
    }


    // ---------------------------------
    // UTILITIES
    public function getRouteKeyName()
    {
        return "slug";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
