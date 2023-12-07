<?php

namespace App\Models\Traits\Helpers;

use App\Models\{User, HistoryConfessionResponse, RecConfession};

trait Responsible
{
  // ---------------------------------
  // METHODS
  public static function getResponseFields(User $user, RecConfession $confession, $response, $status, string $system)
  {
    return [
      "id_confession" => $confession->id_confession,
      "id_user" => $user["id_user"],
      "response" => $response,
      "confession_status" => $status ?? $confession->status,
      "created_by" => $user["full_name"],
      "system_response" => $system,
    ];
  }

  public static function setResponseSystem(User $user, $status)
  {
    $response = '<p>' . $user['full_name'];
    if ($status === "process") $response .= " picked this confession." . '</p>';
    if ($status === "release") $response .= " was released the confession." . '</p>';
    if ($status === "close") $response .= " closed this confession immediately. Thank you!" . '</p>';

    return $response;
  }

  public function setResponsePage($confessionResponses, HistoryConfessionResponse $response)
  {
    foreach ($confessionResponses as $items_index => $items) {
      $page = $items_index + 1;

      foreach ($items as $item)
        if ($item->id_confession_response === $response->id_confession_response)
          $response->page = $page;
    }

    return $response->page;
  }

  public function getPagedConfessionResponses($total, $perPage, $pageNumbers, $responses)
  {
    $confessionResponses = [];

    if ($total >= $perPage)
      for ($index = 0; $index < $pageNumbers; $index++)
        $confessionResponses[] = $responses
          ->skip($index * $perPage)
          ->take($perPage)
          ->all();
    else
      $confessionResponses[] = $responses->all();

    return $confessionResponses;
  }

  public function isYourResponse(User $user, HistoryConfessionResponse $response, $message = "Tanggapan tidak ditemukan.")
  {
    if ($response->id_user !== $user->id_user) throw new \Exception($message);
  }

  public function isSystemResponse(HistoryConfessionResponse $response, $message = "Tanggapan sistem tidak bisa di-unsend.")
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
