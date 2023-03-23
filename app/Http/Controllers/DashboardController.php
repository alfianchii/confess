<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\{DashboardService, ChartService, GreetingService};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService, $chartService;

    // Constructor to add services
    public function __construct(DashboardService $dashboardService, ChartService $chartService)
    {
        $this->dashboardService = $dashboardService;
        $this->chartService = $chartService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->dashboardService->index();

        return view("dashboard.index", $response);
    }

    public function chartData()
    {
        // Return the chart data (JSON response)
        return $this->chartService->responses(auth()->user());
    }
}
