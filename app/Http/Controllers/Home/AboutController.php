<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\{AboutService};

class AboutController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected AboutService $aboutService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(AboutService $aboutService)
    {
        parent::__construct();
        $this->aboutService = $aboutService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->aboutService->index();
    }
}