<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{RecConfession};
use App\Services\Home\ConfessionService;
use Illuminate\Http\Request;

class ConfessionController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected ConfessionService $confessionService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(ConfessionService $confessionService)
    {
        parent::__construct();
        $this->confessionService = $confessionService;
    }


    // ---------------------------------
    // CORES
    public function index(Request $request)
    {
        return $this->confessionService->index($request);
    }


    // ---------------------------------
    // UTILITIES
}
