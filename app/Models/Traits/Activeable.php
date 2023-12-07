<?php

namespace App\Models\Traits;

trait Activeable
{
  // ---------------------------------
  // METHODS
  public function isActiveData(string $flagActive, $message = "Data tidak aktif.")
  {
    if ($flagActive === "N") throw new \Exception($message);
  }

  public function isNonActiveData(string $flagActive, $message = "Data sudah aktif.")
  {
    if ($flagActive === "Y") throw new \Exception($message);
  }
}
