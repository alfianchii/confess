<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\HomeService;

class HomeController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected HomeService $homeService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(HomeService $homeService)
    {
        parent::__construct();
        $this->homeService = $homeService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->homeService->index();
    }


    // ---------------------------------
    // UTILITIES
}
