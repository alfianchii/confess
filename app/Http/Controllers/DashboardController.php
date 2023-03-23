<?php

namespace App\Http\Controllers;

use App\Models\{Complaint, Officer, Response, Student};
use App\Services\ChartService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $chartService;

    // Constructor to add services
    public function __construct(ChartService $chartService)
    {
        $this->chartService = $chartService;
    }

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

    public function chartData()
    {
        // Return the chart data (JSON response)
        return $this->chartService->responses(auth()->user());
    }
}
