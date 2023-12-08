<?php

namespace App\Services\Dashboard;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Storage, Validator};
use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{HistoryConfessionResponse, RecConfession, MasterConfessionCategory, MasterRole, User};
use App\Models\Traits\{Exportable};
use App\Models\Traits\Helpers\{Confessable, Responsible};
use App\Exports\Confessions\{AllOfConfessionsExport, ConfessionsHandledByYouExport, UnprocessedConfessionsExport, YourConfessionsExport};

class ConfessionService extends Service
{
  // ---------------------------------
  // TRAITS
  use Confessable, Responsible, Exportable;


  // ---------------------------------
  // PROPERTIES
  private array $rules = [
    "title" => ["required", "max:255"],
    "slug" => ["required", "unique:rec_confessions"],
    "date" => ["required", "date", "date_format:Y-m-d"],
    "id_confession_category" => ["required"],
    "place" => ["required"],
    "privacy" => ["required"],
    "image" => ["image", "file", "max:10240"],
    "body" => ["required"],
  ];

  private array $messages = [
    "title.required" => "Judul pengakuan harus diisi.",
    "title.max" => "Judul pengakuan maksimal :max karakter.",
    "slug.required" => "Slug pengakuan harus diisi.",
    "slug.unique" => "Slug pengakuan sudah ada.",
    "date.required" => "Tanggal pengakuan harus diisi.",
    "date.date" => "Tanggal pengakuan harus berupa :date.",
    "date.date_format" => "Tanggal pengakuan harus berformat :date_format.",
    "id_confession_category.required" => "Kategori pengakuan harus diisi.",
    "place.required" => "Tempat pengakuan harus diisi.",
    "privacy.required" => "Privasi pengakuan harus diisi.",
    "image.image" => "Gambar pengakuan harus berupa :image.",
    "image.file" => "Gambar pengakuan harus berupa :file.",
    "image.max" => "Gambar pengakuan maksimal :max KiB.",
    "body.required" => "Isi pengakuan harus diisi.",
  ];


  // ---------------------------------
  // CORES
  public function index(User $user, MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex($user);
    if ($roleName === "officer") return $this->officerIndex($user);
    if ($roleName === "student") return $this->studentIndex($user);

    return view("errors.403");
  }

  public function create(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentCreate();

    return view("errors.403");
  }

  public function store(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentStore($data, $user);

    return view("errors.403");
  }

  public function edit(User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Data processing
    $id = $confession->id_confession;
    $confession = $confession
      ->with(['category'])
      ->where("id_confession", $id)
      ->first();

    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentEdit($user, $confession);

    return view("errors.403");
  }

  public function update(Request $request, User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentUpdate($data, $user, $confession);

    return view("errors.403");
  }

  public function destroy(User $user, MasterRole $userRole, $slug)
  {
    // Data processing
    $confession = RecConfession::with(["responses", "comments", "likes"])->where("slug", $slug)->first();
    if (!$confession) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentDestroy($user, $confession);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function export(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();
    $validator = $this->exportValidates($data);
    if ($validator->fails()) return view("errors.403");
    $creds = $validator->validate();

    $fileName = $this->getExportFileName($creds["type"]);
    $writterType = $this->getWritterType($creds["type"]);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminExport($creds["table"], $fileName, $writterType);
    if ($roleName === "officer") return $this->officerExport($creds["table"], $fileName, $writterType, $user);
    if ($roleName === "student") return $this->studentExport($creds["table"], $fileName, $writterType, $user);

    return view("errors.403");
  }

  public function destroyImage(User $user, MasterRole $userRole, $slug)
  {
    // Data processing
    $confession = RecConfession::where("slug", $slug)->first();
    if (!$confession) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentDestroyImage($user, $confession);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function checkSlug(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentCheckSlug($data);

    return view("errors.403");
  }

  public function pick(User $user, MasterRole $userRole, RecConfession $confession)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerPick($user, $confession);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function release(User $user, MasterRole $userRole, RecConfession $confession)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerRelease($user, $confession);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function close(User $user, MasterRole $userRole, RecConfession $confession)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerClose($user, $confession);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  public function adminIndex()
  {
    $allConfessions = RecConfession::with(["category", "student.user", "responses", "comments", "likes"])
      ->latest("updated_at")
      ->get();

    $unprocessedConfessions = $allConfessions
      ->where(
        fn ($query) => $query->assigned_to === null &&
          ($query->status === "unprocess" || $query->status === "release")
      );

    $viewVariables = [
      "title" => "Pengakuan",
      "allConfessions" => $allConfessions,
      "unprocessedConfessions" => $unprocessedConfessions,
    ];
    return view("pages.dashboard.actors.admin.confessions.index", $viewVariables);
  }

  public function adminExport(string $table, string $fileName, $writterType)
  {
    if ($table === "all-of-confessions")
      return $this->exports((new AllOfConfessionsExport), $fileName, $writterType);
    if ($table === "unprocessed-confessions")
      return $this->exports((new UnprocessedConfessionsExport), $fileName, $writterType);

    return view("errors.404");
  }


  // OFFICER
  public function officerIndex(User $user)
  {
    $allConfessions = RecConfession::with(["category", "student.user", "responses", "comments", "likes"])
      ->latest("updated_at")
      ->get();

    $confessionsHandledByYou = $allConfessions
      ->where("assigned_to", $user->id_user)
      ->where("status", "process");

    $unprocessedConfessions = $allConfessions->where(
      fn ($query) => $query->assigned_to === null &&
        ($query->status === "unprocess" || $query->status === "release")
    );

    $viewVariables = [
      "title" => "Pengakuan",
      "allConfessions" => $allConfessions,
      "confessionsHandledByYou" => $confessionsHandledByYou,
      "unprocessedConfessions" => $unprocessedConfessions,
    ];
    return view("pages.dashboard.actors.officer.confessions.index", $viewVariables);
  }

  public function officerExport(string $table, string $fileName, $writterType, User $user)
  {
    if ($table === "all-of-confessions")
      return $this->exports((new AllOfConfessionsExport), $fileName, $writterType);
    if ($table === "confessions-handled-by-you")
      return $this->exports((new ConfessionsHandledByYouExport)->forAssignedTo($user->id_user), $fileName, $writterType);
    if ($table === "unprocessed-confessions")
      return $this->exports((new UnprocessedConfessionsExport), $fileName, $writterType);

    return view("errors.404");
  }

  public function officerPick(User $user, RecConfession $confession)
  {
    try {
      $this->isNotAssignedToYou($user, $confession, "Pengakuan ini sudah kamu atau orang lain pick.");

      // ---------------------------------
      // Rules
      if (($confession->status === "unprocess" || $confession->status === "release")) {
        $confession->update([
          "status" => "process",
          "assigned_to" => $user->id_user,
          "updated_at" => now(),
        ]);

        HistoryConfessionResponse::setResponse($user, $confession, null, $confession->status, "Y");
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan pick ketika status confession bukan "unprocess".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Pengakuan telah di-pick!");
  }

  public function officerRelease(User $user, RecConfession $confession)
  {
    try {
      $this->isAssignedToYou($user, $confession);

      // ---------------------------------
      // Rules
      if ($confession->status === "process") {
        $confession->update([
          "status" => "release",
          "assigned_to" => null,
          "updated_at" => now(),
        ]);

        HistoryConfessionResponse::setResponse($user, $confession, null, $confession->status, "Y");
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan release ketika status confession bukan "process".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Pengakuan telah di-release!");
  }

  public function officerClose(User $user, RecConfession $confession)
  {
    try {
      $this->isAssignedToYou($user, $confession, "Pengakuan ini sudah kamu close.");

      // ---------------------------------
      // Rules
      if ($confession->status === "process") {
        // Close
        $confession->update([
          "status" => "close",
          "updated_at" => now(),
        ]);

        HistoryConfessionResponse::setResponse($user, $confession, null, $confession->status, "Y");
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan close ketika status confession bukan "process".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Pengakuan telah di-close");
  }


  // STUDENT
  public function studentIndex(User $user)
  {
    $confessions = RecConfession::with(['category', "responses", "likes"])
      ->where('id_user', $user->id_user)
      ->latest()
      ->get();

    $viewVariables = [
      "title" => "Pengakuan",
      "confessions" => $confessions,
    ];
    return view("pages.dashboard.actors.student.confessions.index", $viewVariables);
  }

  public function studentCreate()
  {
    $confessionCategories = MasterConfessionCategory::active()->get()->sortBy("category_name");

    $viewVariables = [
      "title" => "Buat Pengakuan",
      "confessionCategories" => $confessionCategories,
    ];
    return view("pages.dashboard.actors.student.confessions.create", $viewVariables);
  }

  public function studentStore($data, User $user)
  {
    $credentials = Validator::make($data, $this->rules, $this->messages)->validate();
    $credentials = $this->file(null, $credentials, "image", "confession/images");
    $credentials["id_user"] = $user->id_user;
    $credentials["excerpt"] = Str::limit(strip_tags($credentials["body"]), 50, ' ...');
    $credentials["status"] = "unprocess";

    try {
      $credentials["id_confession_category"] = $this->getActiveConfessionCategoryId($credentials["id_confession_category"]);
      $confession = RecConfession::create($credentials);
      $response = '<p>' . $user['full_name'] .  ' made a confession.' . '</p>';
      HistoryConfessionResponse::setResponse($user, $confession, $response, $confession->status, "Y");
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    return redirect($this->createResponseURL($confession->slug))->withSuccess('Pengakuan kamu berhasil dibuat!');
  }

  public function studentEdit(User $user, RecConfession $confession)
  {
    try {
      $this->isYourConfession($user, $confession);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess") {
      $confessionCategories = MasterConfessionCategory::active()->get()->sortBy("category_name");

      $viewVariables = [
        "title" => "Sunting Pengakuan",
        "confession" => $confession,
        "confessionCategories" => $confessionCategories,
      ];
      return view("pages.dashboard.actors.student.confessions.edit", $viewVariables);
    };

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa melakukan sunting ketika status confession bukan "unprocess".');
  }

  public function studentUpdate($data, User $user, RecConfession $confession)
  {
    try {
      $this->isYourConfession($user, $confession);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess") {
      $rules = $this->slugRules($this->rules, $data['slug'], $confession->slug);

      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials["id_confession_category"] = MasterConfessionCategory::where('slug', $credentials["id_confession_category"])->active()->value('id_confession_category');
      $credentials = $this->file($confession->image, $credentials, "image", 'confession/images');
      $credentials["id_user"] = $user->id_user;
      $credentials["excerpt"] = Str::limit(strip_tags($data["body"]), 50, ' ...');

      return $this->modify($confession, $credentials, $user->id_user, "pengakuan", $this->createResponseURL($data["slug"]));
    }

    return redirect(self::HOME_URL)
      ->withErrors('Kamu tidak bisa melakukan sunting ketika status confession bukan "unprocess".');
  }

  public function studentDestroy(User $user, RecConfession $confession)
  {
    try {
      $this->isYourConfession($user, $confession);

      // ---------------------------------
      // Rules
      if ($confession->status === "unprocess") {
        if ($confession->image) Storage::delete($confession->image);
        if (!RecConfession::destroy($confession->id_confession)) throw new \Exception('Error unsend confession.');
        $confession->update(["updated_by" => $user->id_user]);
        $this->deleteConfessionResponses($confession->responses);
        $this->deleteConfessionComments($confession->comments);
        $this->deleteConfessionLikes($confession->likes);
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan unsend ketika status confession bukan "unprocess".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Pengakuan kamu telah di-unsend!");
  }

  public function studentExport(string $table, string $fileName, $writterType, User $user)
  {
    if ($table === "your-confessions")
      return $this->exports((new YourConfessionsExport)->forIdUser($user->id_user), $fileName, $writterType);

    return view("errors.404");
  }

  public function studentDestroyImage(User $user, RecConfession $confession)
  {
    try {
      $this->isYourConfession($user, $confession);

      // ---------------------------------
      // Rules
      if ($confession->status === "unprocess") {
        if ($confession->image) Storage::delete($confession->image);
        $confession->update(["updated_by" => $user->id_user, "image" => null]);
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan unsend ketika status confession bukan "unprocess".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Foto pengakuan kamu telah di-unsend!");
  }

  public function studentCheckSlug($data)
  {
    $slug = SlugService::createSlug(RecConfession::class, "slug", $data['title']);

    $slug .= "-" . rand(0, 10000);

    return response()->json(["slug" => $slug]);
  }
}
