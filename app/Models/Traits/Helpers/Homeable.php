<?php

namespace App\Models\Traits\Helpers;

trait Homeable
{
  // ---------------------------------
  // PROPERTIES


  // ---------------------------------
  // METHODS
  public function confessionRequests(array $data, string $username, string $category)
  {
    $title = "";
    $title = $this->isRequest("user", $data) ? "oleh " . $username : $title;
    $title = $this->isRequest("category", $data) ? "dengan " . $category : '';
    $title = $this->isRequest("status", $data) ? "dengan " . $this->isRequest("status", $data) : $title;
    $title = $this->isRequest("privacy", $data) ? "dengan " . $this->isRequest("privacy", $data) : $title;
    return $title;
  }
  public function isRequest(string $str, array $data)
  {
    return array_key_exists($str, $data);
  }
}
