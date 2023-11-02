<?php

namespace App\Models\Traits\Helpers;

use App\Models\{User};

trait Accountable
{
  public function isYourAccount(User $yourAccount, User $user, string $message = "Akun tidak ditemukan.")
  {
    if ($yourAccount->id_user !== $user->id_user) throw new \Exception($message);
  }
}
