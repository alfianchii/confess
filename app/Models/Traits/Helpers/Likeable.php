<?php

namespace App\Models\Traits\Helpers;

use App\Models\{HistoryConfessionLike, User, RecConfession};

trait Likeable
{
  // ---------------------------------
  // METHODS
  public static function likeFields(RecConfession $confession, User $user)
  {
    return [
      "id_user" => $user->id_user,
      "id_confession" => $confession->id_confession,
      "created_at" => now(),
    ];
  }

  public function isLiked(RecConfession $confession, User $user)
  {
    return $confession->likes->contains("id_user", $user->id_user);
  }

  public function disliked(RecConfession $confession, User $user)
  {
    $idLike = $confession->likes->where("id_user", $user->id_user)->value("id_confession_like");

    return HistoryConfessionLike::destroy($idLike);
  }

  public function liked(array $fields)
  {
    return HistoryConfessionLike::create($fields);
  }
}
