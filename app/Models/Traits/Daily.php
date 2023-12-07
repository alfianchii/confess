<?php

namespace App\Models\Traits;

trait Daily
{
  // ---------------------------------
  // METHODS
  public static function getTotalDays()
  {
    return now()->daysInMonth;
  }

  public function greeting()
  {
    $hour = now()->hour;
    if ($hour >= 5 && $hour <= 11) return 'Selamat pagi';
    if ($hour >= 12 && $hour <= 15) return 'Selamat siang';
    if ($hour >= 16 && $hour <= 18) return 'Selamat sore';

    return 'Selamat malam';
  }
}
