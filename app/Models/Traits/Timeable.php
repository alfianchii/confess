<?php

namespace App\Models\Traits;

trait Timeable
{
  // ---------------------------------
  // METHODS
  public function secondToMinute(int $seconds)
  {
    return floor($seconds / 60);
  }
}
