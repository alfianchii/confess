<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\CommentService as DashboardCommentService;
use Illuminate\Http\Request;

class RecConfessionCommentController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected DashboardCommentService $dashboardCommentService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(DashboardCommentService $dashboardCommentService)
    {
        parent::__construct();
        $this->dashboardCommentService = $dashboardCommentService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->dashboardCommentService->index($this->userData, $this->userRole);
    }

    public function edit($idConfessionComment)
    {
        return $this->dashboardCommentService->edit($this->userData, $idConfessionComment);
    }

    public function update(Request $request, $idConfessionComment)
    {
        return $this->dashboardCommentService->update($request, $this->userData, $idConfessionComment);
    }

    public function export(Request $request)
    {
        return $this->dashboardCommentService->export($request, $this->userData, $this->userRole);
    }


    // ---------------------------------
    // UTILITIES
    public function destroyAttachment($idConfessionComment)
    {
        return $this->dashboardCommentService->destroyAttachment($this->userData, $idConfessionComment);
    }
}
