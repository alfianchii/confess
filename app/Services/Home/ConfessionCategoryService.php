<?php

namespace App\Services\Home;

use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{MasterConfessionCategory};

class ConfessionCategoryService extends Service
{
  // ---------------------------------
  // CORES
  public function index(Request $request)
  {
    // Data processing
    $data = $request->only(["search"]);
    $confessionCategories = MasterConfessionCategory::with(["confessions"])
      ->orderBy("category_name", "asc")
      ->filter($data)
      ->paginate(3)
      ->withQueryString();

    return $this->allIndex($confessionCategories);
  }


  // ---------------------------------
  // UTILITIES
  public function allIndex($confessionCategories)
  {
    $viewVariables = [
      "title" => "Kategori Pengakuan",
      "confessionCategories" => $confessionCategories,
    ];
    return view("pages.landing-page.confession-categories.index", $viewVariables);
  }
}
