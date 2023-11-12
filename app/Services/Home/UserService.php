<?php

namespace App\Services\Home;

use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;

class UserService extends Service
{
  // ---------------------------------
  // TRAITS


  // ---------------------------------
  // PROPERTIES


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
    // Passing out a view
    $viewVariables = [
      "title" => "Pengguna @$theUser->username",
      "theUser" => $theUser,
    ];
    return view("pages.landing-page.users.index", $viewVariables);
  }
}
