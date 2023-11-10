<?php

namespace App\Services\Dashboard;

use App\Exports\Confessions\Responses\{AllOfResponsesExport, YourResponsesExport};
use App\Models\{HistoryConfessionResponse, MasterRole, RecConfession, User};
use App\Models\Traits\Exportable;
use App\Models\Traits\Helpers\{Confessable, Responsible};
use Illuminate\Support\Facades\{Storage, Validator};
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResponseService extends Service
{
  // ---------------------------------
  // TRAITS
  use Confessable, Responsible, Exportable;


  // ---------------------------------
  // PROPERTIES
  protected array $rules = [
    "response" => ["required"],
    "attachment_file" => ["nullable", "file", "mimes:pdf,jpg,jpeg,png,heic,docs,doc,csv,xls,xlsx", "max:10240"],
    "status" => ["required", "string"],
  ];

  protected array $messages = [
    "response.required" => "Tanggapan tidak boleh kosong.",
    "attachment_file.file" => "Tanggapan harus berupa :file.",
    "attachment_file.mimes" => "Tanggapan harus berupa file dengan format: :values.",
    "attachment_file.max" => "File pendukung tidak boleh lebih dari :max KiB.",
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

  public function create(User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Data processing
    $idConfession = $confession->id_confession;
    $confession = $confession
      ->with(["student.user", "category", "officer.user"])
      ->where("id_confession", $idConfession)
      ->first();

    // User's role
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminCreate($confession);
    if ($roleName === "officer") return $this->officerCreate($confession);
    if ($roleName === "student") return $this->studentCreate($user, $confession);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function store(Request $request, User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerStore($data, $user, $confession);
    if ($roleName === "student") return $this->studentStore($data, $user, $confession);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function edit(User $user, MasterRole $userRole, $idConfessionResponse)
  {
    // Data processing
    $id = $this->idDecrypted($idConfessionResponse);
    $response = HistoryConfessionResponse::where("id_confession_response", $id)->first();
    $confession = RecConfession::with(["student.user", "category"])
      ->where("id_confession", $response->id_confession)
      ->first();
    if (!$response || !$confession) return view("errors.404");

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerEdit($user, $confession, $response);
    if ($roleName === "student") return $this->studentEdit($user, $confession, $response);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function update(Request $request, User $user, MasterRole $userRole, $idConfessionResponse)
  {
    // Data processing
    $data = $request->all();
    $id = $this->idDecrypted($idConfessionResponse);
    $response = HistoryConfessionResponse::with(["confession.student.user", "confession.category"])
      ->where("id_confession_response", $id)
      ->paginateResponsesFromConfession(self::PER_PAGE)
      ->first();
    if (!$response) return view("errors.404");

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerUpdate($data, $user, $response);
    if ($roleName === "student") return $this->studentUpdate($data, $user, $response);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function destroy(User $user, MasterRole $userRole, $idConfessionResponse)
  {
    // Data processing
    $id = $this->idDecrypted($idConfessionResponse);
    $response = HistoryConfessionResponse::with(["confession.student.user"])
      ->where("id_confession_response", $id)
      ->first();
    if (!$response) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerDestroy($user, $response);
    if ($roleName === "student") return $this->studentDestroy($user, $response);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function export(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();
    $validator = $this->exportValidates($data);
    if ($validator->fails()) return view("errors.403");
    $creds = $validator->validate();

    // Validates
    $fileName = $this->getExportFileName($creds["type"]);
    $writterType = $this->getWritterType($creds["type"]);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminExport($creds["table"], $fileName, $writterType);
    if ($roleName === "officer") return $this->adminExport($creds["table"], $fileName, $writterType, $user);
    if ($roleName === "student") return $this->adminExport($creds["table"], $fileName, $writterType, $user);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function destroyAttachment(User $user, MasterRole $userRole, $idConfessionResponse)
  {
    // Data processing
    $id = $this->idDecrypted($idConfessionResponse);
    $response = HistoryConfessionResponse::with(["confession.student.user"])
      ->where("id_confession_response", $id)
      ->first();
    if (!$response->attachment_file) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerDestroyAttachment($user, $response);
    if ($roleName === "student") return $this->studentDestroyAttachment($user, $response);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  // Index
  private function adminIndex()
  {
    $allResponses = HistoryConfessionResponse::with([
      "confession",
      "user",
    ])
      ->where("history_confession_responses.system_response", "N")
      ->latest()
      ->paginateResponsesFromConfession(self::PER_PAGE);

    // Passing out a view
    $viewVariables = [
      "title" => "Tanggapan",
      "allResponses" => $allResponses,
    ];
    return view("pages.dashboard.actors.admin.responses.index", $viewVariables);
  }
  // Create
  private function adminCreate(RecConfession $confession)
  {
    // ---------------------------------
    // Pagination
    // Short the responses based on a confession (created at)
    $sortedResponses = HistoryConfessionResponse::with(["user"])
      ->where("id_confession", $confession->id_confession)
      ->latest()
      ->paginate(self::PER_PAGE);

    // Passing out a view
    $viewVariables = [
      "title" => ucwords($confession->title),
      "confession" => $confession,
      "responses" => $sortedResponses,
    ];
    return view("pages.dashboard.actors.admin.responses.create", $viewVariables);
  }
  // Export
  public function adminExport(string $table, string $fileName, $writterType)
  {
    // Table
    if ($table === "all-of-responses")
      return $this->exports((new AllOfResponsesExport), $fileName, $writterType);

    // Redirect to not found page
    return view("errors.404");
  }


  // OFFICER
  // Index
  private function officerIndex(User $user)
  {
    $allResponses = HistoryConfessionResponse::with([
      "confession",
      "user",
    ])
      ->where("system_response", "N")
      ->latest()
      ->paginateResponsesFromConfession(self::PER_PAGE);

    $yourResponses = $allResponses->where("id_user", $user->id_user);

    // Passing out a view
    $viewVariables = [
      "title" => "Tanggapan",
      "allResponses" => $allResponses,
      "yourResponses" => $yourResponses,
    ];
    return view("pages.dashboard.actors.officer.responses.index", $viewVariables);
  }
  // Create
  private function officerCreate(RecConfession $confession)
  {
    // ---------------------------------
    // Pagination
    // Short the responses based on a confession (created at)
    $sortedResponses = HistoryConfessionResponse::with(["user"])
      ->where("id_confession", $confession->id_confession)
      ->latest()
      ->paginate(self::PER_PAGE);

    // Passing out a view
    $viewVariables = [
      "title" => ucwords($confession->title),
      "confession" => $confession,
      "responses" => $sortedResponses,
    ];
    return view("pages.dashboard.actors.officer.responses.create", $viewVariables);
  }
  // Store
  private function officerStore($data, User $user,  RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isAssignedToYou($user, $confession);
    } catch (\Exception $e) {
      return redirect("/dashboard")->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if (($confession->status === "unprocess" || $confession->status === "process")) {
      // Validates
      $credentials = Validator::make($data, $this->rules, $this->messages)->validate();
      $credentials = $this->file(null, $credentials, "attachment_file", "confession/response/attachment-files");
      $optFields = ["attachment_file" => $credentials["attachment_file"] ?? null];

      // Insert response w/ changing status
      if ($credentials["status"] === "process")
        $response = HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $credentials["status"], "N", $optFields);
      if ($credentials["status"] === "release") {
        $response = HistoryConfessionResponse::setResponse($user, $confession, null, $credentials["status"], "Y");
        HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $confession->status, "N", $optFields);
        // Confession
        $credentials["assigned_to"] = null;
      }
      if ($credentials["status"] === "close")
        $response = HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $credentials["status"], "N", $optFields);

      // Update confession
      $confession->update($credentials);

      // Success
      return redirect($this->createResponsesURLWithParam($confession->slug) . base64_encode($response->id_confession_response))->withSuccess("Tanggapan kamu berhasil dibuat.");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa memberikan tanggapan ketika status confession bukan "unprocess" atau "process".');
  }
  // Edit
  private function officerEdit(User $user, RecConfession $confession, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect("/dashboard/confessions/responses")->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess" || $confession->status === "process") {
      // Passing out a view
      $viewVariables = [
        "title" => "Sunting Tanggapan",
        "response" => $response,
        "confession" => $confession,
      ];
      return view("pages.dashboard.actors.officer.responses.edit", $viewVariables);
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa editing tanggapan ketika status confession bukan "unprocess" atau "process".');
  }
  // Update
  private function officerUpdate($data, User $user, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect("/dashboard/confessions/responses")->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($response->confession->status === "unprocess" || $response->confession->status === "process") {
      // Page
      $page = $response->page;
      unset($response->page);
      // Rules
      $rules = $this->rules;
      unset($rules["status"]);

      // Validates
      $credentials = Validator::make($data, $rules, $this->messages)->validate();

      // Confession
      $confession = RecConfession::where("id_confession", $response->id_confession)->first();
      $credentials = $this->file($response->attachment_file, $credentials, "attachment_file", "confession/response/attachment-files");

      return $this->modify($response, $credentials, $user->id_user, "tanggapan", $this->createResponsesURLWithParam($confession->slug) . base64_encode($response->id_confession_response) . "&page=$page");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa editing tanggapan ketika status confession bukan "unprocess" atau "process".');
  }
  // Destroy
  private function officerDestroy(User $user, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);
      $this->isSystemResponse($response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess" || $response->confession->status === "process") {
        // Destroy the response
        if (!HistoryConfessionResponse::destroy($response->id_confession_response)) throw new \Exception('Error unsend response.');
        // Update by
        $response->update(["updated_by" => $user->id_user]);
        // Destroy the attachment file if exists
        if ($response->attachment_file) Storage::delete($response->attachment_file);
      } else return $this->responseJsonMessage("Kamu tidak bisa melakukan unsend ketika status confession bukan 'unprocess' atau 'process'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Tanggapan kamu berhasil di-unsend!");
  }
  // Export
  public function officerExport(string $table, string $fileName, $writterType, User $user)
  {
    // Table
    if ($table === "all-of-responses")
      return $this->exports((new AllOfResponsesExport), $fileName, $writterType);
    if ($table === "your-responses")
      return $this->exports((new YourResponsesExport)->forIdUser($user->id_user), $fileName, $writterType);

    // Redirect to not found page
    return view("errors.404");
  }
  // Destroy Attachment
  private function officerDestroyAttachment(User $user, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess" || $response->confession->status === "process") {
        // Destroy the attachment file
        if (!Storage::delete($response->attachment_file)) throw new \Exception('Error unsend attachment file.');
        // Update the attachment file and update by
        $response->update(["attachment_file" => null, "updated_by" => $user->id_user]);
      } else return $this->responseJsonMessage("Kamu tidak bisa unsend file pendukung ketika status confession bukan 'unprocess' atau 'process'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("File pendukung berhasil dihapus.");
  }


  // STUDENT
  // Index
  private function studentIndex(User $user)
  {
    $yourResponses = HistoryConfessionResponse::with([
      "confession",
    ])
      ->where("id_user", $user->id_user)
      ->where("system_response", "N")
      ->latest()
      ->paginateResponsesFromConfession(self::PER_PAGE);

    // Passing out a view
    $viewVariables = [
      "title" => "Tanggapan",
      "yourResponses" => $yourResponses,
    ];
    return view("pages.dashboard.actors.student.responses.index", $viewVariables);
  }
  // Create
  private function studentCreate(User $user,  RecConfession $confession)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourConfession($user, $confession);
    } catch (\Exception $e) {
      return redirect('/dashboard')->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Pagination
    // Short the responses based on a confession (created at)
    $sortedResponses = HistoryConfessionResponse::with(["user"])
      ->where("id_confession", $confession->id_confession)
      ->latest()
      ->paginate(self::PER_PAGE);

    // Passing out a view
    $viewVariables = [
      "title" => ucwords($confession->title),
      "confession" => $confession,
      "responses" => $sortedResponses,
    ];
    return view("pages.dashboard.actors.student.responses.create", $viewVariables);
  }
  // Store
  private function studentStore($data, User $user,  RecConfession $confession)
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
    if ($confession->status === "unprocess" || $confession->status === "process") {
      // Rules
      $rules = $this->rules;
      unset($rules["status"]);

      // Validates
      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials = $this->file(null, $credentials, "attachment_file", "confession/response/attachment-files");
      $optFields = ["attachment_file" => $credentials["attachment_file"] ?? null];
      $response = HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $confession->status, "N", $optFields);

      // Success
      return redirect($this->createResponsesURLWithParam($confession->slug) . base64_encode($response->id_confession_response))->withSuccess("Tanggapan kamu berhasil dibuat.");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa memberikan tanggapan ketika status confession bukan "unprocess" atau "process".');
  }
  // Edit
  private function studentEdit(User $user, RecConfession $confession, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect("/dashboard/confessions/responses")->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess") {
      // Passing out a view
      $viewVariables = [
        "title" => "Sunting Tanggapan",
        "response" => $response,
        "confession" => $confession,
      ];
      return view("pages.dashboard.actors.student.responses.edit", $viewVariables);
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa sunting tanggapan ketika status confession bukan "unprocess".');
  }
  // Update
  private function studentUpdate($data, User $user, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect("/dashboard/confessions/responses")->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($response->confession->status === "unprocess") {
      // Page
      $page = $response->page;
      unset($response->page);
      // Rules
      $rules = $this->rules;
      unset($rules["status"]);

      // Validates
      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials = $this->file($response->attachment_file, $credentials, "attachment_file", "confession/response/attachment-files");

      return $this->modify($response, $credentials, $user->id_user, "tanggapan", $this->createResponsesURLWithParam($response->confession->slug) . base64_encode($response->id_confession_response) . "&page=$page");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa memberikan tanggapan ketika status confession bukan "unprocess".');
  }
  // Destroy
  private function studentDestroy(User $user, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);
      $this->isSystemResponse($response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess") {
        // Destroy the response
        if (!HistoryConfessionResponse::destroy($response->id_confession_response)) throw new \Exception('Error unsend response.');
        // Update by
        $response->update(["updated_by" => $user->id_user]);
        // Destroy the attachment file if exists
        if ($response->attachment_file) Storage::delete($response->attachment_file);
      } else return $this->responseJsonMessage("Kamu tidak bisa melakukan unsend ketika status confession bukan 'unprocess'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Tanggapan kamu telah di-unsend!");
  }
  // Export
  public function studentExport(string $table, string $fileName, $writterType, User $user)
  {
    // Table
    if ($table === "your-responses")
      return $this->exports((new YourResponsesExport)->forIdUser($user->id_user), $fileName, $writterType);

    // Redirect to not found page
    return view("errors.404");
  }
  // Destroy attachment
  private function studentDestroyAttachment(User $user, HistoryConfessionResponse $response)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourResponse($user, $response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess") {
        // Destroy the attachment file
        if (!Storage::delete($response->attachment_file)) throw new \Exception('Error unsend attachment file.');
        // Update the attachment file and update by
        $response->update(["attachment_file" => null, "updated_by" => $user->id_user]);
      } else return $this->responseJsonMessage("Kamu tidak bisa unsend file pendukung ketika status confession bukan 'unprocess' atau 'process'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("File pendukung kamu telah di-unsend!");
  }
}
