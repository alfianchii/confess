<?php

namespace App\Services\Home;

use App\Services\Service;

class AboutService extends Service
{
  // ---------------------------------
  // TRAITS


  // ---------------------------------
  // PROPERTIES


  // ---------------------------------
  // CORES
  public function index()
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Tentang " . config('web_config')['TEXT_WEB_TITLE'],
    ];
    return view("pages.landing-page.about.index", $viewVariables);
  }


  // ---------------------------------
  // UTILITIES
}
