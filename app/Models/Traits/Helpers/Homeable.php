<?php

namespace App\Models\Traits\Helpers;

use App\Models\{User, RecConfession};

trait Homeable
{
  // ---------------------------------
  // METHODS
  public function filteredConfessions(array $data, User $user)
  {
    $confessions = $this->getFilteredConfessions($data, $user);
    return $confessions->paginate(7)->withQueryString();
  }

  public function getFilteredConfessions(array $data, User $user)
  {
    $confessions = RecConfession::with(["category", "student.user", "comments", "likes"])
      ->filter($data)
      ->isLiked($user);
    $confessions = $this->filterdConfessions($confessions);

    return $confessions->latest();
  }

  public function filterdConfessions($confessions)
  {
    $uri = request()->getUri();
    if (str_contains($uri, "/confessions/top"))
      $confessions = $confessions->orderByDesc("total_likes");

    return $confessions;
  }

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
