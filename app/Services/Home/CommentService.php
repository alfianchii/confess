<?php

namespace App\Services\Home;

use App\Services\Service;
use App\Models\{RecConfession, RecConfessionComment, User};
use App\Models\Traits\Helpers\{Commentable, Homeable};

class CommentService extends Service
{
  // ---------------------------------
  // TRAITS
  use Homeable, Commentable;


  // ---------------------------------
  // CORES
  public function create(RecConfession $confession)
  {
    // Data processing
    $id = $confession->id_confession;
    $confession = $confession
      ->with(["category", "student.user", "comments.user"])
      ->where("id_confession", $id)
      ->first();

    return $this->allCreate($confession);
  }

  public function edit(User $user, $idConfessionComment)
  {
    // Data processing
    $id = $this->idDecrypted($idConfessionComment);
    $comment = RecConfessionComment::where("id_confession_comment", $id)->first();
    $confession = RecConfession::with(["student.user", "category"])
      ->where("id_confession", $comment->id_confession)
      ->first();
    if (!$comment || !$confession) return view("errors.404");

    return $this->allEdit($user, $confession, $comment);
  }


  // ---------------------------------
  // UTILITIES
  public function allCreate(RecConfession $confession)
  {
    $sortedComments = $confession
      ->comments()
      ->with(["user"])
      ->latest()
      ->paginate(self::PER_PAGE);

    $viewVariables = [
      "title" => $confession->title,
      "confession" => $confession,
      "comments" => $sortedComments,
    ];
    return view("pages.landing-page.comments.create", $viewVariables);
  }

  public function allEdit(User $user, RecConfession $confession, RecConfessionComment $comment)
  {
    try {
      $this->isYourComment($user, $comment);
    } catch (\Exception $e) {
      return redirect("/confessions")->withErrors($e->getMessage());
    }

    $viewVariables = [
      "title" => "Sunting Komentar",
      "comment" => $comment,
      "confession" => $confession,
    ];
    return view("pages.landing-page.comments.edit", $viewVariables);
  }
}
