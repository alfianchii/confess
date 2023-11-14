<?php

namespace App\Models\Traits;

trait Validatory
{
  // ---------------------------------
  // METHODS
  public function idDecrypted($unique)
  {
    try {
      $id = (int) base64_decode($unique);
      if (!$id) throw new \Exception("Failed to decrypt.");
    } catch (\Exception $e) {
      return redirect('/dashboard')->withErrors($e->getMessage());
    }

    return $id;
  }
}
