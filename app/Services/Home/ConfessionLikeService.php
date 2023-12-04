<?php

namespace App\Services\Home;

use App\Services\Service;
use App\Models\{User, RecConfession, HistoryConfessionLike};
use App\Models\Traits\Helpers\{Likeable};
use Illuminate\Http\Request;

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
    else $this->liked($this->fields($confession, $user));

    return redirect()->back();
  }
}