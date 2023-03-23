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

    // protected $with = [
    //     'officer',
    //     'complaint',
    // ];

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
}
