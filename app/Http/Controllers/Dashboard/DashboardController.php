<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\{DashboardService, ChartService};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
