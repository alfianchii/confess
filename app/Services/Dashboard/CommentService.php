<?php

namespace App\Services\Dashboard;

use App\Services\Service;
use App\Models\{RecConfession, RecConfessionComment, User};
use App\Models\Traits\Helpers\{Commentable, Homeable};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Validator};

class CommentService extends Service
{
  // ---------------------------------
  // TRAITS
  use Homeable, Commentable;


  // ---------------------------------
  // PROPERTIES
  protected array $rules = [
    "comment" => ["required"],
    "privacy" => ["required"],
    "attachment_file" => ["nullable", "file", "mimes:pdf,jpg,jpeg,png,heic,docs,doc,csv,xls,xlsx", "max:10240"],
  ];

  protected array $messages = [
    "comment.required" => "Komentar tidak boleh kosong.",
    "privacy.required" => "Privasi komentar tidak boleh kosong.",
    "attachment_file.file" => "File komentar harus berupa :file.",
    "attachment_file.mimes" => "File komentar harus berupa file dengan format: :values.",
    "attachment_file.max" => "File pendukung tidak boleh lebih dari :max KiB.",
  ];


  // ---------------------------------
  // CORES
  public function store(Request $request, User $user,  RecConfession $confession)
  {
    // Data processing
    $data = $request->all();

    return $this->allStore($data, $user, $confession);
  }

  public function update(Request $request, User $user, $idConfessionComment)
  {
    // Data processing
    $data = $request->all();
    $id = $this->idDecrypted($idConfessionComment);
    $comment = RecConfessionComment::with(["confession.student.user", "confession.category"])
      ->where("id_confession_comment", $id)
      ->paginateCommentsFromConfession(self::PER_PAGE)
      ->first();
    if (!$comment) return view("errors.404");

    return $this->allUpdate($data, $user, $comment);
  }

  public function destroy(User $user, $idConfessionComment)
  {
    // Data processing
    $id = $this->idDecrypted($idConfessionComment);
    $comment = RecConfessionComment::with(["confession.student.user"])
      ->where("id_confession_comment", $id)
      ->first();
    if (!$comment) return $this->responseJsonMessage("The data you are looking not found.", 404);

    return $this->allDestroy($user, $comment);
  }

  public function destroyAttachment(User $user, $idConfessionComment)
  {
    // Data processing
    $id = $this->idDecrypted($idConfessionComment);
    $comment = RecConfessionComment::firstWhere("id_confession_comment", $id);
    if (!$comment) return $this->responseJsonMessage("The data you are looking not found.", 404);

    return $this->allDestroyAttachment($user, $comment);
  }


  // ---------------------------------
  // UTILITIES
  // ALL
  public function allStore($data, User $user, RecConfession $confession)
  {
    // Validates
    $credentials = Validator::make($data, $this->rules, $this->messages)->validate();
    $credentials = $this->file(null, $credentials, "attachment_file", "confession/comment/attachment-files");
    $optFields = ["attachment_file" => $credentials["attachment_file"] ?? null];

    // Insert comment
    $comment = RecConfessionComment::setComment($user, $confession, $credentials["comment"], $credentials["privacy"], $optFields);

    // Success
    return redirect($this->createCommentsURLWithParam($confession->slug) . base64_encode($comment->id_confession_comment))->withSuccess("Komentar kamu berhasil dibuat.");
  }
  public function allUpdate($data, User $user, RecConfessionComment $comment)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourComment($user, $comment);
    } catch (\Exception $e) {
      return redirect("/confessions")->withErrors($e->getMessage());
    }

    // Page
    $page = $comment->page;
    unset($comment->page);

    // Validates
    $credentials = Validator::make($data, $this->rules, $this->messages)->validate();

    // Confession
    $confession = RecConfession::where("id_confession", $comment->id_confession)->first();
    $credentials = $this->file($comment->attachment_file, $credentials, "attachment_file", "confession/comment/attachment-files");

    return $this->modify($comment, $credentials, $user->id_user, "komentar", $this->createCommentsURLWithParam($confession->slug) . base64_encode($comment->id_confession_comment) . "&page=$page");
  }
  public function allDestroy(User $user, RecConfessionComment $comment)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourComment($user, $comment);

      // Destroy the comment
      if (!RecConfessionComment::destroy($comment->id_confession_comment)) throw new \Exception('Error unsend comment.');
      // Update by
      $comment->update(["updated_by" => $user->id_user]);
      // Destroy the attachment file if exists
      if ($comment->attachment_file) Storage::delete($comment->attachment_file);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Komentar kamu berhasil di-unsend!");
  }
  public function allDestroyAttachment(User $user, RecConfessionComment $comment)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourComment($user, $comment);

      // Destroy the attachment file
      if (!Storage::delete($comment->attachment_file)) throw new \Exception('Error unsend attachment file.');
      // Update the attachment file and update by
      $comment->update(["attachment_file" => null, "updated_by" => $user->id_user]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("File pendukung berhasil dihapus.");
  }
}
