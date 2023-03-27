<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = ['officer', 'complaint'];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class, 'officer_nik', 'officer_nik');
    }

    public static function yourResponseAxises()
    {
        // Your responses
        $responses = Response::where("officer_nik", auth()->user()->nik)
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            // Select the date of creation and count of responses for each day
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy('date', "created_at")
            // Order the results by date in ascending order
            ->orderBy('date', 'asc')
            // Execute the query and retrieve the results
            ->get();

        // Create an array to store the response counts for each day
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        // Loop through the date range and populate the counts array with the responses counts
        foreach (Carbon::now()->subDays(6)->toPeriod(Carbon::now()) as $date) {
            $counts = 0;

            foreach ($responses as $response) {
                if ($date->format("Y-m-d") == $response->date) {
                    $counts += $response->count;
                }
            }

            $axises['yAxis'][] = $counts;
            $axises['xAxis'][] = $date->format("Y-m-d");
        }

        return $axises;
    }

    public static function allResponseAxises()
    {
        // All Responses
        $allResponses = Response::whereBetween('responses.created_at', [Carbon::now()->subDays(7), Carbon::now()])
            // Select the date of creation and count of responses for each day
            ->selectRaw("DATE(responses.created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy('date')
            // Order the results by date in ascending order
            ->orderBy('date', 'asc')
            // Execute the query and retrieve the results
            ->get();

        // All responses' genders
        $genders = Response::join("officers", 'responses.officer_nik', "=", "officers.officer_nik")
            ->join("users", 'officers.officer_nik', "=", "users.nik")
            ->selectRaw('SUM(CASE WHEN users.gender = "L" THEN 1 ELSE 0 END) as male')
            ->selectRaw('SUM(CASE WHEN users.gender = "P" THEN 1 ELSE 0 END) as female')
            ->first()->attributes;

        // Create an array to store the all responses' data
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

        // Loop through the date range and populate the counts array with the all response counts
        foreach (Carbon::now()->subDays(6)->toPeriod(Carbon::now()) as $date) {
            $counts = 0;

            foreach ($allResponses as $response) {
                if ($date->format("Y-m-d") == $response->date) {
                    $counts += $response->count;
                }
            }

            $axises["data"]['yAxis'][] = $counts;
            $axises["data"]['xAxis'][] = $date->format("Y-m-d");
        }

        // Convert string to int
        foreach ($genders as $gender => $value) {
            $axises['genders'][$gender] = (int) $value;
        }

        return $axises;
    }
}