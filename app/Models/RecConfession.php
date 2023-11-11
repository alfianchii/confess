<?php

namespace App\Models;

use App\Models\Traits\Daily;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->hasMany(RecConfessionComment::class, "id_confession", "id_confession");
    }


    // ---------------------------------
    // HELPERS
    public function getRouteKeyName()
    {
        return "slug";
    }

    /*
        Data Scheme:
            xAxis
            yAxis
    */
    public static function yourConfessionAxises(User $user)
    {
        // Your confessions
        $yourConfessions = RecConfession::where("id_user", $user->id_user)
            ->whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of confessions for each day
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy("date", "created_at")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // Create an array to store the confessions counts for each day
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        // Loop through the date range and populate the counts array with the confessions counts
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

    /*
        Data Scheme:
            data
                xAxis
                yAxis
            genders
                male
                female
    */
    public static function confessionAxises()
    {
        // All Confessions
        $confessions = RecConfession::whereBetween("rec_confessions.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of confessions for each day
            ->selectRaw("DATE(rec_confessions.created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy("date", "rec_confessions.created_at")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // Genders
        $genders = RecConfession::leftJoin("dt_students", "rec_confessions.id_user", "=", "dt_students.id_user")
            ->leftJoin("mst_users", "dt_students.id_user", "=", "mst_users.id_user")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        // Create an array to store the all confessions' data
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

        // Loop through the date range and populate the counts array with the confession counts
        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($confessions as $confession) {
                if ($date->format("Y-m-d") == $confession->date) $counts += $confession->count;
            }

            $axises['data']['yAxis'][] = $counts;
            $axises['data']['xAxis'][] = $date->format("Y-m-d");
        }

        // Convert string to int
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

        // Filter by user
        if ($user) $query->where("rec_confessions.id_user", $user->id_user);

        // Return the filtered results
        if (!$limit) return $query;

        // Return limited results
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
            $str = "";

            // Convert enum
            if ($filters["status"] == "not") $str = "0";
            if ($filters["status"] == "proc") $str = "1";
            if ($filters["status"] == "done") $str = "2";


            return $query->with("student")->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->where('status', $str);
        }

        /* SEARCH: CONFESSION AND PRIVACY */
        if (isset($filters["search"]) && isset($filters["privacy"])) {
            $str = "";

            // Convert enum
            if ($filters["privacy"] == "anyone") $str = "public";
            if ($filters["privacy"] == "private") $str = "anonymous";

            // Do query
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
                        $query->with("confessions")->where("privacy", $str)
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


    // ---------------------------------
    // UTILITIES
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}