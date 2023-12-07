<?php

namespace App\Services\Home;

use App\Services\Service;

class AboutService extends Service
{
  // ---------------------------------
  // CORES
  public function index()
  {
    return $this->allIndex();
  }


  // ---------------------------------
  // UTILITIES
  public function allIndex()
  {
    $viewVariables = [
      "title" => "Tentang " . config('web_config')['TEXT_WEB_TITLE'],
    ];
    return view("pages.landing-page.about.index", $viewVariables);
  }
}
