<?php

namespace App\Http\Controllers\Home;

use App\Models\User;
use App\Services\Home\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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


  // ---------------------------------
  // UTILITIES
}
