<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\RecConfession;
use App\Services\Home\ConfessionLikeService;

class ConfessionLikeController extends Controller
{
  // ---------------------------------
  // PROPERTIES
  protected ConfessionLikeService $confessionLikeService;


  // ---------------------------------
  // MAGIC FUNCTIONS
  public function __construct(ConfessionLikeService $confessionLikeService)
  {
    parent::__construct();
    $this->confessionLikeService = $confessionLikeService;
  }


  // ---------------------------------
  // CORES
  public function likeDislike(RecConfession $confession)
  {
    return $this->confessionLikeService->likeDislike($confession, $this->userData);
  }


  // ---------------------------------
  // UTILITIES
}
