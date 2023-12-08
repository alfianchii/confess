<?php

namespace App\Models\Traits\Helpers;

use App\Models\{RecConfession, RecConfessionComment, User};

trait Commentable
{
  // ---------------------------------
  // METHODS
  public static function getCommentFields(User $user, RecConfession $confession, $comment, $privacy)
  {
    return [
      "id_confession" => $confession->id_confession,
      "id_user" => $user["id_user"],
      "comment" => $comment,
      "privacy" => $privacy,
      "created_by" => $user["full_name"],
    ];
  }

  public function setCommentPage($confessionComments, RecConfessionComment $comment)
  {
    foreach ($confessionComments as $items_index => $items) {
      $page = $items_index + 1;

      foreach ($items as $item)
        if ($item->id_confession_comment === $comment->id_confession_comment)
          $comment->page = $page;
    }

    return $comment->page;
  }

  public function getPagedConfessionComments($total, $perPage, $pageNumbers, $comments)
  {
    $confessionComments = [];

    if ($total >= $perPage)
      for ($index = 0; $index < $pageNumbers; $index++)
        $confessionComments[] = $comments
          ->skip($index * $perPage)
          ->take($perPage)
          ->all();
    else
      $confessionComments[] = $comments->all();

    return $confessionComments;
  }

  public function isYourComment(User $user, RecConfessionComment $comment, $message = "Komentar ini bukan milikmu.")
  {
    if ($comment->id_user !== $user->id_user) throw new \Exception($message);
  }

  public function createCommentsURLWithParam(string $slug)
  {
    return "/confessions/$slug/comments/create?comment=";
  }
}
