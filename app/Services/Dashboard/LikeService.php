<?php

namespace App\Services\Dashboard;

use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{User, MasterRole, HistoryConfessionLike};
use App\Models\Traits\{Exportable};
use App\Exports\Confessions\Likes\{AllOfLikesExport, YourLikesExport};

class LikeService extends Service
{
  // ---------------------------------
  // TRAITS
  use Exportable;


  // ---------------------------------
  // CORES
  public function index(User $user, MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex($user);

    return view("errors.403");
  }

  public function export(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();
    $validator = $this->exportValidates($data);
    if ($validator->fails()) return view("errors.403");
    $creds = $validator->validate();

    $fileName = $this->getExportFileName($creds["type"]);
    $writterType = $this->getWritterType($creds["type"]);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminExport($creds["table"], $fileName, $writterType, $user);

    return view("errors.403");
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  private function adminIndex(User $user)
  {
    $allLikes = HistoryConfessionLike::with([
      "confession.student.user",
      "user",
    ])
      ->latest()
      ->get();

    $yourLikes = $allLikes->where("id_user", $user->id_user);

    $viewVariables = [
      "title" => "Suka",
      "allLikes" => $allLikes,
      "yourLikes" => $yourLikes,
    ];
    return view("pages.dashboard.actors.admin.likes.index", $viewVariables);
  }

  public function adminExport(string $table, string $fileName, $writterType, User  $user)
  {
    if ($table === "all-of-likes")
      return $this->exports((new AllOfLikesExport), $fileName, $writterType);
    if ($table === "your-likes")
      return $this->exports((new YourLikesExport)->forIdUser($user->id_user), $fileName, $writterType);

    return view("errors.404");
  }
}