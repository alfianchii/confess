<?php

namespace App\Models\Traits\Helpers;

use App\Models\{RecConfessionComment, User};

trait Commentable
{
  // ---------------------------------
  // PROPERTIES


  // ---------------------------------
  // METHODS
  public function isYourComment(User $user, RecConfessionComment $comment, $message = "Komentar ini bukan milikmu.")
  {
    if ($comment->id_user !== $user->id_user) throw new \Exception($message);
  }
  public function createCommentsURLWithParam(string $slug)
  {
    return "/confessions/$slug/comments/create?comment=";
  }
}
