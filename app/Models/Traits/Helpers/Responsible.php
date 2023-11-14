<?php

namespace App\Models\Traits\Helpers;

use App\Models\{User, HistoryConfessionResponse};

trait Responsible
{
  // ---------------------------------
  // METHODS
  public function isYourResponse(User $user, HistoryConfessionResponse $response, $message = "Tanggapan tidak ditemukan.")
  {
    if ($response->id_user !== $user->id_user) throw new \Exception($message);
  }
  public function isSystemResponse(HistoryConfessionResponse $response, $message = "Tanggapan sistem tidak bisa dihapus.")
  {
    if ($response->system_response === "Y") throw new \Exception($message);
  }
  public function createResponseURL(string $slug)
  {
    return "/dashboard/confessions/$slug/responses/create";
  }
  public function createResponsesURLWithParam(string $slug)
  {
    return "/dashboard/confessions/$slug/responses/create?response=";
  }
}
