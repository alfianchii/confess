<?php

namespace App\Models\Traits;

trait Setable
{
  // ---------------------------------
  // METHODS
  public static function setOtherFields($fields, array $params)
  {
    foreach ($params as $key => $value) {
      $fields[$key] = $value;
    }

    return $fields;
  }
}
