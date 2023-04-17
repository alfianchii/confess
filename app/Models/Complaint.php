<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    protected $with = ['category', 'student'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        /* SEARCH: COMPLAINT AND USER */
        if (isset($filters["search"]) && isset($filters["user"])) {
            return $query->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->whereHas(
                    "student",
                    fn ($query) =>
                    $query->whereHas(
                        "user",
                        fn ($query) =>
                        $query->where("username", $filters["user"])
                            ->where('privacy', 'public')
                    )
                );
        }

        /* SEARCH: COMPLAINT AND CATEGORY */
        if (isset($filters["search"]) && isset($filters["category"])) {
            return $query->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->whereHas(
                    "category",
                    fn ($query) =>
                    $query->where("slug", $filters["category"])
                );
        }

        /* SEARCH: COMPLAINT AND STATUS */
        if (isset($filters["search"]) && isset($filters["status"])) {
            $str = "";

            // Convert enum
            if ($filters["status"] == "not") $str = "0";
            if ($filters["status"] == "proc") $str = "1";
            if ($filters["status"] == "done") $str = "2";


            return $query->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->where('status', $str);
        }

        /* SEARCH: COMPLAINT AND PRIVACY */
        if (isset($filters["search"]) && isset($filters["status"])) {
            $str = "";

            // Convert enum
            if ($filters["privacy"] == "anyone") $str = "public";
            if ($filters["privacy"] == "anon") $str = "anonymous";

            // Do query
            return $query->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $filters["search"] . "%")
                    ->orWhere("body", "like", "%" . $filters["search"] . "%")
            )
                ->whereHas(
                    "student",
                    fn ($query) =>
                    $query->whereHas(
                        "complaints",
                        fn ($query) =>
                        $query->where("privacy", $str)
                    )
                );
        }

        /* SEARCH: COMPLAINT */
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
                $query->whereHas(
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
        if (isset($filters["status"])) {
            $str = "";

            // Convert enum
            if ($filters["status"] == "not") $str = "0";
            if ($filters["status"] == "proc") $str = "1";
            if ($filters["status"] == "done") $str = "2";

            // Do query
            // return $query->where("status", $str);
            return $query->where("status", $str);
        }

        /* SEARCH: PRIVACY */
        if (isset($filters["privacy"])) {
            $str = "";

            // Convert enum
            if ($filters["privacy"] == "anyone") $str = "public";
            if ($filters["privacy"] == "anon") $str = "anonymous";

            // Do query
            return $query->where('privacy', $str);
        }
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_nik', 'student_nik');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public static function yourComplaintAxises()
    {
        // Your complaints
        $complaints = Complaint::where("student_nik", auth()->user()->nik)
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            // Select the date of creation and count of complaints for each day
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy('date', "created_at")
            // Order the results by date in ascending order
            ->orderBy('date', 'asc')
            // Execute the query and retrieve the results
            ->get();

        // Create an array to store the complaints counts for each day
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        // Loop through the date range and populate the counts array with the complaints counts
        foreach (Carbon::now()->subDays(6)->toPeriod(Carbon::now()) as $date) {
            $counts = 0;

            foreach ($complaints as $complaint) {
                if ($date->format("Y-m-d") == $complaint->date) {
                    $counts += $complaint->count;
                }
            }

            $axises['yAxis'][] = $counts;
            $axises['xAxis'][] = $date->format("Y-m-d");
        }

        return $axises;
    }

    public static function allComplaintAxises()
    {
        // All Complaints
        $allComplaints = Complaint::whereBetween('complaints.created_at', [Carbon::now()->subDays(7), Carbon::now()])
            // Select the date of creation and count of complaints for each day
            ->selectRaw("DATE(complaints.created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy('date', 'complaints.created_at')
            // Order the results by date in ascending order
            ->orderBy('date', 'asc')
            // Execute the query and retrieve the results
            ->get();

        // Genders
        $genders = Complaint::join("students", 'complaints.student_nik', "=", "students.student_nik")
            ->join("users", 'students.student_nik', "=", "users.nik")
            ->selectRaw('SUM(CASE WHEN users.gender = "L" THEN 1 ELSE 0 END) as male')
            ->selectRaw('SUM(CASE WHEN users.gender = "P" THEN 1 ELSE 0 END) as female')
            ->first()->attributes;

        // Create an array to store the all complaints' data
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

        // Loop through the date range and populate the counts array with the complaint counts
        foreach (Carbon::now()->subDays(6)->toPeriod(Carbon::now()) as $date) {
            $counts = 0;

            foreach ($allComplaints as $complaint) {
                if ($date->format("Y-m-d") == $complaint->date) {
                    $counts += $complaint->count;
                }
            }

            $axises['data']['yAxis'][] = $counts;
            $axises['data']['xAxis'][] = $date->format("Y-m-d");
        }

        // Convert string to int
        foreach ($genders as $gender => $value) {
            $axises['genders'][$gender] = (int) $value;
        }

        return $axises;
    }
}
