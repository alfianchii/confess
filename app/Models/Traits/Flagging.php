<?php

namespace App\Models\Traits;

trait Flagging
{
  // ---------------------------------
  // METHODS
  public static function bootFlagging()
  {
    static::addGlobalScope('active', function ($query) {
      return $query->where('flag_active', 'Y');
    });
  }
}
