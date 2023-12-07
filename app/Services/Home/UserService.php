<?php

namespace App\Services\Home;

use App\Services\Service;
use App\Models\{User};

class UserService extends Service
{
  // ---------------------------------
  // CORES
  public function index(User $theUser)
  {
    // Data processing
    $theUser = User::with(["userRole.role", "student", "officer"])
      ->firstWhere("id_user", $theUser->id_user);

    return $this->allIndex($theUser);
  }


  // ---------------------------------
  // UTILITIES
  public function allIndex(User $theUser)
  {
    $viewVariables = [
      "title" => "Pengguna @$theUser->username",
      "theUser" => $theUser,
    ];
    return view("pages.landing-page.users.index", $viewVariables);
  }
}
