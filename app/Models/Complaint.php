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
