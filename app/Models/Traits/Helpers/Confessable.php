<?php

namespace App\Models\Traits\Helpers;

use App\Models\{User, RecConfession};

trait Confessable
{
  public function isYourConfession(User $user, RecConfession $confession, $message = "Pengakuan ini bukan milikmu.")
  {
    if ($confession->id_user !== $user->id_user) throw new \Exception($message);
  }
  public function isAssignedToYou(User $user, RecConfession $confession, $message = "Pengakuan ini bukan ditugaskan ke kamu.")
  {
    if ($confession->assigned_to !== $user->id_user) throw new \Exception($message);
  }
  public function isNotAssignedToYou(User $user, RecConfession $confession, $message = "Pengakuan ini sudah ditugaskan ke kamu.")
  {
    if ($confession->assigned_to === $user->id_user) throw new \Exception($message);
  }
}
