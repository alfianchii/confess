<?php

namespace App\Http\Controllers;

use App\Models\{Complaint, Officer, Response, Student};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Timezone
        $currentTime = Carbon::now();
        $hour = $currentTime->hour;

        if ($hour >= 5 && $hour <= 13) {
            $greeting = 'Selamat pagi';
        } elseif ($hour >= 14 && $hour <= 17) {
            $greeting = 'Selamat sore';
        } else {
            $greeting = 'Selamat malam';
        }

        // Complaints
        $complaints = Complaint::orderByDesc("created_at")->get() ?? [];

        // Officers
        $officers = Officer::all();

        // Students
        $students = Student::all();

        // Responses
        $responses = Response::orderByDesc("created_at")->get() ?? [];

        return view("dashboard.index", [
            "title" => "Dashboard",
            "greeting" => $greeting,
            "complaints" => $complaints,
            "officers" => $officers,
            "students" => $students,
            "responses" => $responses,
        ]);
    }

    public function responsesData()
    {
        // Response
        $responseAxises = Response::yourResponseAxises();
        $allResponseAxises = Response::allResponseAxises();

        // Complaint
        $complaintAxises = Complaint::yourComplaintAxises();
        $allComplaintAxises = Complaint::AllComplaintAxises();

        // JSON response
        $results = [
            'chart' => [
                "data" => [],
            ],
            "authentication" => [
                "data" => [
                    "level" => auth()->user()->level,
                ],
            ],
        ];

        // Check level
        if (auth()->user()->level === "admin") {
            // All complaints
            $results['chart']["data"]["allComplaints"] = $allComplaintAxises;
            // All responses
            $results['chart']["data"]["allResponses"] = $allResponseAxises;
            // Your responses
            $results['chart']["data"]["responses"] = $responseAxises;
        } else if (auth()->user()->level === "officer") {
            $results['chart']["data"]["allResponses"] = $allResponseAxises;
            $results['chart']["data"]["responses"] = $responseAxises;
        } else if (auth()->user()->level === "student") {
            $results['chart']["data"]["allComplaints"] = $allComplaintAxises;
            $results['chart']["data"]["complaints"] = $complaintAxises;
        }

        // Return the chart data as a JSON response
        return response()->json($results);
    }
}
