<?php

namespace App\Services\Home;

use App\Services\Service;
use App\Models\RecConfession;

class HomeService extends Service
{
  // ---------------------------------
  // TRAITS


  // ---------------------------------
  // PROPERTIES


  // ---------------------------------
  // CORES
  public function index()
  {
    // Data processing
    $confessionsCount = RecConfession::count();

    return $this->allIndex($confessionsCount);
  }


  // ---------------------------------
  // UTILITIES
  public function allIndex($confessionsCount)
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Selamat Datang",
      "confessionsCount" => $confessionsCount,
    ];
    return view("pages.landing-page.home.index", $viewVariables);
  }
}
