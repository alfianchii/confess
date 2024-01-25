<?php

namespace App\Models\Traits\Helpers;

use Illuminate\Support\Facades\{Storage};
use App\Models\{HistoryConfessionLike, HistoryConfessionResponse, User, RecConfession, MasterConfessionCategory, RecConfessionComment};

trait Confessable
{
  // ---------------------------------
  // METHODS
  public function isYourConfession(User $user, RecConfession $confession, $message = "Pengakuan ini bukan milikmu.")
  {
    if ($confession->id_user !== $user->id_user) throw new \Exception($message);
  }

  public function isAssignedToYou(User $user, RecConfession $confession, $message = "Pengakuan ini bukan ditugaskan ke kamu.")
  {
    if ($confession->assigned_to !== $user->id_user) throw new \Exception($message);
  }

  public function isNotAssignedToYou(User $user, RecConfession $confession, $message = "Pengakuan ini sudah ditugaskan ke kamu.")
  {
    if ($confession->assigned_to === $user->id_user) throw new \Exception($message);
  }

  public function getActiveConfessionCategoryId($slug)
  {
    $confessionCategory = MasterConfessionCategory::where('slug', $slug)->active()->value('id_confession_category');
    if (!$confessionCategory) throw new \Exception("Kategori pengakuan tidak ada.");
    return $confessionCategory;
  }

  public function deleteConfessionResponses($responses)
  {
    foreach ($responses as $response) {
      if ($response->attachment_file) Storage::delete($response->attachment_file);
      if (!HistoryConfessionResponse::destroy($response->id_confession_response)) throw new \Exception('Error unsend confession.');
    };
  }

  public function deleteConfessionComments($comments)
  {
    foreach ($comments as $comment) {
      if ($comment->attachment_file) Storage::delete($comment->attachment_file);
      if (!RecConfessionComment::destroy($comment->id_confession_comment)) throw new \Exception('Error unsend confession.');
    };
  }

  public function deleteConfessionLikes($likes)
  {
    foreach ($likes as $like) {
      if (!HistoryConfessionLike::destroy($like->id_confession_like)) throw new \Exception('Error unsend confession.');
    };
  }
}
