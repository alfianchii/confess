<?php

namespace App\Http\Controllers\Dashboards;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\{DashboardService, ChartService};

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
        $response = $this->dashboardService->index(auth()->user());

        return view("dashboard.index", $response);
    }

    public function chartData()
    {
        // Return the chart data (JSON response)
        return $this->chartService->responses(auth()->user());
    }
}
