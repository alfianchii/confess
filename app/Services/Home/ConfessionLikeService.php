<?php

namespace App\Services\Home;

use App\Services\Service;
use App\Models\{User, RecConfession};
use App\Models\Traits\Helpers\{Likeable};

class ConfessionLikeService extends Service
{
  // ---------------------------------
  // TRAITS
  use Likeable;


  // ---------------------------------
  // PROPERTIES


  // ---------------------------------
  // CORES
  public function likeDislike(RecConfession $confession, User $user)
  {
    // Data processing
    $id = $confession->id_confession;
    $confession = $confession
      ->with(["likes"])
      ->firstWhere("id_confession", $id);

    return $this->allLikeDislike($confession, $user);
  }


  // ---------------------------------
  // UTILITIES
  public function allLikeDislike(RecConfession $confession, User $user)
  {
    // Check if user is liked this confession
    $isLiked = $this->isLiked($confession, $user);

    // Like or dislike
    if ($isLiked) $this->disliked($confession, $user);
    else $this->liked(self::likeFields($confession, $user));

    return back();
  }
}
