<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\{DashboardService, ChartService};

class DashboardController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected DashboardService $dashboardService;
    protected ChartService $chartService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(DashboardService $dashboardService, ChartService $chartService)
    {
        parent::__construct();
        $this->dashboardService = $dashboardService;
        $this->chartService = $chartService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->dashboardService->index($this->userData, $this->userRole);
    }

    public function chartData(Request $request)
    {
        return $this->chartService->index($request, $this->userData, $this->userRole);
    }
}
