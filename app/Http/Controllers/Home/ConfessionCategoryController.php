<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Home\ConfessionCategoryService;

class ConfessionCategoryController extends Controller
{
  // ---------------------------------
  // PROPERTIES
  protected ConfessionCategoryService $confessionCategoryService;


  // ---------------------------------
  // MAGIC FUNCTIONS
  public function __construct(ConfessionCategoryService $confessionCategoryService)
  {
    parent::__construct();
    $this->confessionCategoryService = $confessionCategoryService;
  }


  // ---------------------------------
  // CORES
  public function index(Request $request)
  {
    return $this->confessionCategoryService->index($request);
  }
}
