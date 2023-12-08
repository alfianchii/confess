<?php

namespace App\Services\Home;

use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{User, MasterConfessionCategory};
use App\Models\Traits\Helpers\{Homeable};

class ConfessionService extends Service
{
  // ---------------------------------
  // TRAITS
  use Homeable;


  // ---------------------------------
  // PROPERTIES
  protected const REQUEST = ["user", "search", "category", "status", "privacy"];


  // ---------------------------------
  // CORES
  public function index(Request $request, User $user)
  {
    // Data processing
    $data = $request->only(self::REQUEST);
    $category = MasterConfessionCategory::firstWhere("slug", $request->category)->category_name ?? '';
    $username = User::firstWhere("username", $request->user)->full_name ?? "";
    $confessions = $this->filteredConfessions($data, $user);
    $title = $this->confessionRequests($data, $username, $category);

    return $this->allIndex($title, $confessions);
  }


  // ---------------------------------
  // UTILITIES
  public function allIndex(string $title, $confessions)
  {
    $viewVariables = [
      "title" => "Pengakuan $title",
      "confessions" => $confessions,
    ];
    return view("pages.landing-page.confessions.index", $viewVariables);
  }
}
