<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{RecConfession};
use App\Services\Dashboard\CommentService as DashboardCommentService;
use App\Services\Home\CommentService;

class CommentController extends Controller
{
  // ---------------------------------
  // PROPERTIES
  protected CommentService $commentService;
  protected DashboardCommentService $dashboardCommentService;


  // ---------------------------------
  // MAGIC FUNCTIONS
  public function __construct(CommentService $commentService, DashboardCommentService $dashboardCommentService)
  {
    parent::__construct();
    $this->commentService = $commentService;
    $this->dashboardCommentService = $dashboardCommentService;
  }


  // ---------------------------------
  // CORES
  public function create(RecConfession $confession)
  {
    return $this->commentService->create($confession);
  }

  public function store(Request $request, RecConfession $confession)
  {
    return $this->dashboardCommentService->store($request, $this->userData, $confession);
  }

  public function edit($idConfessionComment)
  {
    return $this->commentService->edit($this->userData, $idConfessionComment);
  }

  public function update(Request $request, $idConfessionComment)
  {
    return $this->dashboardCommentService->update($request, $this->userData, $idConfessionComment);
  }

  public function destroy($idConfessionComment)
  {
    return $this->dashboardCommentService->destroy($this->userData, $idConfessionComment);
  }
}
