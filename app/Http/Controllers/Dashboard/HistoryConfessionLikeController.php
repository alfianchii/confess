<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\LikeService;
use App\Http\Controllers\Controller;
use App\Models\{RecConfession};
use Illuminate\Http\Request;

class HistoryConfessionLikeController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected LikeService $likeService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(LikeService $likeService)
    {
        parent::__construct();
        $this->likeService = $likeService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->likeService->index($this->userData, $this->userRole);
    }

    public function export(Request $request)
    {
        return $this->likeService->export($request, $this->userData, $this->userRole);
    }
}
