<?php

namespace App\Services\Home;

use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{User, MasterConfessionCategory, RecConfession};
use App\Models\Traits\Helpers\{Homeable};

class ConfessionService extends Service
{
  // ---------------------------------
  // TRAITS
  use Homeable;


  // ---------------------------------
  // CORES
  public function index(Request $request, User $user)
  {
    // Data processing
    $data = $request->only(["user", "search", "category", "status", "privacy"]);

    $confessions = RecConfession::with(["category", "student.user", "comments", "likes"])
      ->latest()
      ->filter($data)
      ->isLiked($user)
      ->paginate(7)
      ->withQueryString();
    $category = MasterConfessionCategory::firstWhere("slug", request("category"))->category_name ?? '';
    $username = User::firstWhere("username", request("user"))->full_name ?? "";
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
