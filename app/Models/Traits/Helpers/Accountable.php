<?php

namespace App\Models\Traits\Helpers;

use App\Models\{User};

trait Accountable
{
  public function isYourAccount(User $yourAccount, User $user, string $message = "Akun tidak ditemukan.")
  {
    if ($yourAccount->id_user !== $user->id_user) throw new \Exception($message);
  }
  public function createRoleUser(User $theUser, array $credentials)
  {
    $theUser->userRole()->create(["id_role" => $credentials["role"]]);
    return $theUser;
  }
  public function createUniqueUser(User $theUser, string $roleName, array $credentials)
  {
    if ($roleName === "officer")
      $theUser->officer()->update([
        "nip" => $credentials["nip"],
      ]);
    if ($roleName === "student")
      $theUser->student()->update([
        "nisn" => $credentials["nisn"],
      ]);

    return $theUser;
  }
}