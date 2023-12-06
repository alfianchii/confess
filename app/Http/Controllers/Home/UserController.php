<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{User};
use App\Services\Home\UserService;

class UserController extends Controller
{
  // ---------------------------------
  // PROPERTIES
  protected UserService $userService;


  // ---------------------------------
  // MAGIC FUNCTIONS
  public function __construct(UserService $userService)
  {
    parent::__construct();
    $this->userService = $userService;
  }


  // ---------------------------------
  // CORES
  public function index(User $user)
  {
    return $this->userService->index($user);
  }
}
