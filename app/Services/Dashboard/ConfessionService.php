<?php

namespace App\Services\Dashboard;

use App\Models\{HistoryConfessionResponse, RecConfession, MasterConfessionCategory, MasterRole, User};
use App\Models\Traits\Helpers\{Confessable, Responsible};
use Illuminate\Support\Facades\{Storage, Validator};
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ConfessionService extends Service
{
  // ---------------------------------
  // TRAITS
  use Confessable, Responsible;


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
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex($user);
    if ($roleName === "officer") return $this->officerIndex($user);
    if ($roleName === "student") return $this->studentIndex($user);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function create(MasterRole $userRole)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentCreate();

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function store(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentStore($data, $user);

    // Redirect to unauthorized page
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

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentEdit($user, $confession);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function update(Request $request, User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentUpdate($data, $user, $confession);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function destroy(User $user, MasterRole $userRole, $slug)
  {
    // Data processing
    $confession = RecConfession::with(["responses"])->where("slug", $slug)->first();
    if (!$confession) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentDestroy($user, $confession);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function destroyImage(User $user, MasterRole $userRole, $slug)
  {
    // Data processing
    $confession = RecConfession::where("slug", $slug)->first();
    if (!$confession) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentDestroyImage($user, $confession);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function checkSlug(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "student") return $this->studentCheckSlug($data);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function pick(User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerPick($user, $confession);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function release(User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerRelease($user, $confession);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function close(User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerClose($user, $confession);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  // Index
  public function adminIndex()
  {
    // All Confessions
    $allConfessions = RecConfession::with(["category", "student.user"])
      ->latest("updated_at")
      ->get();

    // Unprocessed Confessions
    $unprocessedConfessions = $allConfessions
      ->where(
        fn ($query) => $query->assigned_to === null &&
          ($query->status === "unprocess" || $query->status === "release")
      );

    // Passing out a view
    $viewVariables = [
      "title" => "Pengakuan",
      "allConfessions" => $allConfessions,
      "unprocessedConfessions" => $unprocessedConfessions,
    ];
    return view("pages.dashboard.actors.admin.confessions.index", $viewVariables);
  }


  // OFFICER
  // Index
  public function officerIndex(User $user)
  {
    // All Confessions
    $allConfessions = RecConfession::with(["category", "student.user"])
      ->latest("updated_at")
      ->get();

    // Confessions Handled by You
    $confessionsHandledByYou = $allConfessions
      ->where("assigned_to", $user->id_user)
      ->where("status", "process");

    // Unprocessed Confessions
    $unprocessedConfessions = $allConfessions->where(
      fn ($query) => $query->assigned_to === null &&
        ($query->status === "unprocess" || $query->status === "release")
    );

    // Passing out a view
    $viewVariables = [
      "title" => "Pengakuan",
      "allConfessions" => $allConfessions,
      "confessionsHandledByYou" => $confessionsHandledByYou,
      "unprocessedConfessions" => $unprocessedConfessions,
    ];
    return view("pages.dashboard.actors.officer.confessions.index", $viewVariables);
  }
  // Pick
  public function officerPick(User $user, RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isNotAssignedToYou($user, $confession, "Pengakuan ini sudah kamu atau orang lain pick.");

      // ---------------------------------
      // Rules
      if (($confession->status === "unprocess" || $confession->status === "release")) {
        // Pick
        $confession->update([
          "status" => "process",
          "assigned_to" => $user->id_user,
          "updated_at" => now(),
        ]);

        // Response
        HistoryConfessionResponse::setResponse($user, $confession, null, $confession->status, "Y");
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan pick ketika status confession bukan "unprocess".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Pengakuan telah di-pick!");
  }
  // Release
  public function officerRelease(User $user, RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isAssignedToYou($user, $confession);

      // ---------------------------------
      // Rules
      if ($confession->status === "process") {
        // Release
        $confession->update([
          "status" => "release",
          "assigned_to" => null,
          "updated_at" => now(),
        ]);

        // Response
        HistoryConfessionResponse::setResponse($user, $confession, null, $confession->status, "Y");
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan release ketika status confession bukan "process".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Pengakuan telah di-release!");
  }
  // Close
  public function officerClose(User $user, RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isAssignedToYou($user, $confession, "Pengakuan ini sudah kamu close.");

      // ---------------------------------
      // Rules
      if ($confession->status === "process") {
        // Close
        $confession->update([
          "status" => "close",
          "updated_at" => now(),
        ]);

        // Response
        HistoryConfessionResponse::setResponse($user, $confession, null, $confession->status, "Y");
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan close ketika status confession bukan "process".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Pengakuan telah di-close");
  }


  // STUDENT
  // Index
  public function studentIndex(User $user)
  {
    // Your confessions
    $confessions = RecConfession::with(['category'])
      ->where('id_user', $user->id_user)
      ->latest()
      ->get();

    // Passing out a view
    $viewVariables = [
      "title" => "Pengakuan",
      "confessions" => $confessions,
    ];
    return view("pages.dashboard.actors.student.confessions.index", $viewVariables);
  }
  // Create
  public function studentCreate()
  {
    // Confession's categories
    $confessionCategories = MasterConfessionCategory::active()->get()->sortBy("category_name");

    // Passing out a view
    $viewVariables = [
      "title" => "Buat Pengakuan",
      "confessionCategories" => $confessionCategories,
    ];
    return view("pages.dashboard.actors.student.confessions.create", $viewVariables);
  }
  // Store
  public function studentStore($data, User $user)
  {
    // Validates
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
      return redirect('/dashboard/confessions')->withErrors($e->getMessage());
    }

    // Success
    return redirect($this->createResponseURL($confession->slug))->withSuccess('Pengakuan kamu berhasil dibuat!');
  }
  // Edit
  public function studentEdit(User $user, RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourConfession($user, $confession);
    } catch (\Exception $e) {
      return redirect("/dashboard")->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess") {
      // Confession's categories
      $confessionCategories = MasterConfessionCategory::active()->get()->sortBy("category_name");

      // Passing out a view
      $viewVariables = [
        "title" => "Sunting Pengakuan",
        "confession" => $confession,
        "confessionCategories" => $confessionCategories,
      ];
      return view("pages.dashboard.actors.student.confessions.edit", $viewVariables);
    };

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa melakukan sunting ketika status confession bukan "unprocess".');
  }
  // Update
  public function studentUpdate($data, User $user, RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourConfession($user, $confession);
    } catch (\Exception $e) {
      return redirect("/dashboard")->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess") {
      // Rules
      $rules = $this->slugRules($this->rules, $data['slug'], $confession->slug);

      // Validates
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
  // Destroy
  public function studentDestroy(User $user, RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourConfession($user, $confession);

      // ---------------------------------
      // Rules
      if ($confession->status === "unprocess") {
        // Confession's image
        if ($confession->image) Storage::delete($confession->image);
        // Destroy
        if (!RecConfession::destroy($confession->id_confession)) throw new \Exception('Error unsend confession.');
        // Update by
        $confession->update(["updated_by" => $user->id_user]);
        // Destroy its responses
        foreach ($confession->responses as $response) {
          if ($response->attachment_file) Storage::delete($response->attachment_file);
          if (!HistoryConfessionResponse::destroy($response->id_confession_response)) throw new \Exception('Error unsend confession.');
        };
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan unsend ketika status confession bukan "unprocess".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Pengakuan kamu telah di-unsend!");
  }
  // Destroy image
  public function studentDestroyImage(User $user, RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourConfession($user, $confession);

      // ---------------------------------
      // Rules
      if ($confession->status === "unprocess") {
        // Confession's image
        if ($confession->image) Storage::delete($confession->image);
        // Update by
        $confession->update(["updated_by" => $user->id_user, "image" => null]);
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan unsend ketika status confession bukan "unprocess".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Foto pengakuan kamu telah di-unsend!");
  }
  // Check slug
  public function studentCheckSlug($data)
  {
    $slug = SlugService::createSlug(RecConfession::class, "slug", $data['title']);

    // Randomness
    $slug .= "-" . rand(0, 10000);

    return response()->json(["slug" => $slug]);
  }
}
