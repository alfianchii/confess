<?php

namespace App\Services\Home;

use App\Models\MasterConfessionCategory;
use App\Services\Service;
use Illuminate\Http\Request;

class ConfessionCategoryService extends Service
{
  // ---------------------------------
  // TRAITS


  // ---------------------------------
  // PROPERTIES


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

    // Passing out a view
    $viewVariables = [
      "title" => "Kategori Pengakuan",
      "confessionCategories" => $confessionCategories,
    ];
    return view("pages.landing-page.confession-categories.index", $viewVariables);
  }


  // ---------------------------------
  // UTILITIES
}
