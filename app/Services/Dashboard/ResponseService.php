<?php

namespace App\Services\Dashboard;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\{Storage, Validator};
use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{HistoryConfessionResponse, MasterRole, RecConfession, User};
use App\Models\Traits\{Exportable};
use App\Models\Traits\Helpers\{Confessable, Responsible};
use App\Exports\Confessions\Responses\{AllOfResponsesExport, YourResponsesExport};

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
    "attachment_file.file" => "File tanggapan harus berupa :file.",
    "attachment_file.mimes" => "File tanggapan harus berupa file dengan format: :values.",
    "attachment_file.max" => "File pendukung tidak boleh lebih dari :max KiB.",
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

  public function create(User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Data processing
    $idConfession = $confession->id_confession;
    $confession = $confession
      ->with(["student.user", "category", "officer.user"])
      ->where("id_confession", $idConfession)
      ->first();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminCreate($confession);
    if ($roleName === "officer") return $this->officerCreate($confession);
    if ($roleName === "student") return $this->studentCreate($user, $confession);

    return view("errors.403");
  }

  public function store(Request $request, User $user, MasterRole $userRole, RecConfession $confession)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerStore($data, $user, $confession);
    if ($roleName === "student") return $this->studentStore($data, $user, $confession);

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

    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerEdit($user, $confession, $response);
    if ($roleName === "student") return $this->studentEdit($user, $confession, $response);

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

    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerUpdate($data, $user, $response);
    if ($roleName === "student") return $this->studentUpdate($data, $user, $response);

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

    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerDestroy($user, $response);
    if ($roleName === "student") return $this->studentDestroy($user, $response);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
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

  public function destroyAttachment(User $user, MasterRole $userRole, $idConfessionResponse)
  {
    // Data processing
    $id = $this->idDecrypted($idConfessionResponse);
    $response = HistoryConfessionResponse::with(["confession.student.user"])
      ->where("id_confession_response", $id)
      ->first();
    if (!$response->attachment_file) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "officer") return $this->officerDestroyAttachment($user, $response);
    if ($roleName === "student") return $this->studentDestroyAttachment($user, $response);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  private function adminIndex()
  {
    $allResponses = HistoryConfessionResponse::with([
      "confession",
      "user",
    ])
      ->where("history_confession_responses.system_response", "N")
      ->latest()
      ->paginateResponsesFromConfession(self::PER_PAGE);

    $viewVariables = [
      "title" => "Tanggapan",
      "allResponses" => $allResponses,
    ];
    return view("pages.dashboard.actors.admin.responses.index", $viewVariables);
  }

  private function adminCreate(RecConfession $confession)
  {
    $sortedResponses = HistoryConfessionResponse::with(["user"])
      ->where("id_confession", $confession->id_confession)
      ->latest()
      ->paginate(self::PER_PAGE);

    $viewVariables = [
      "title" => ucwords($confession->title),
      "confession" => $confession,
      "responses" => $sortedResponses,
    ];
    return view("pages.dashboard.actors.admin.responses.create", $viewVariables);
  }

  public function adminExport(string $table, string $fileName, $writterType)
  {
    if ($table === "all-of-responses")
      return $this->exports((new AllOfResponsesExport), $fileName, $writterType);

    return view("errors.404");
  }


  // OFFICER
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

    $viewVariables = [
      "title" => "Tanggapan",
      "allResponses" => $allResponses,
      "yourResponses" => $yourResponses,
    ];
    return view("pages.dashboard.actors.officer.responses.index", $viewVariables);
  }

  private function officerCreate(RecConfession $confession)
  {
    $sortedResponses = HistoryConfessionResponse::with(["user"])
      ->where("id_confession", $confession->id_confession)
      ->latest()
      ->paginate(self::PER_PAGE);

    $viewVariables = [
      "title" => ucwords($confession->title),
      "confession" => $confession,
      "responses" => $sortedResponses,
    ];
    return view("pages.dashboard.actors.officer.responses.create", $viewVariables);
  }

  private function officerStore($data, User $user,  RecConfession $confession)
  {
    try {
      $this->isAssignedToYou($user, $confession);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if (($confession->status === "unprocess" || $confession->status === "process")) {
      $credentials = Validator::make($data, $this->rules, $this->messages)->validate();
      $credentials = $this->file(null, $credentials, "attachment_file", "confession/response/attachment-files");
      $optFields = ["attachment_file" => $credentials["attachment_file"] ?? null];

      if ($credentials["status"] === "process")
        $response = HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $credentials["status"], "N", $optFields);
      if ($credentials["status"] === "release") {
        $response = HistoryConfessionResponse::setResponse($user, $confession, null, $credentials["status"], "Y");
        HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $confession->status, "N", $optFields);
        $credentials["assigned_to"] = null;
      }
      if ($credentials["status"] === "close")
        $response = HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $credentials["status"], "N", $optFields);

      $confession->update($credentials);

      return redirect($this->createResponsesURLWithParam($confession->slug) . base64_encode($response->id_confession_response))->withSuccess("Tanggapan kamu berhasil dibuat.");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa memberikan tanggapan ketika status confession bukan "unprocess" atau "process".');
  }

  private function officerEdit(User $user, RecConfession $confession, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess" || $confession->status === "process") {
      $viewVariables = [
        "title" => "Sunting Tanggapan",
        "response" => $response,
        "confession" => $confession,
      ];
      return view("pages.dashboard.actors.officer.responses.edit", $viewVariables);
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa editing tanggapan ketika status confession bukan "unprocess" atau "process".');
  }

  private function officerUpdate($data, User $user, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($response->confession->status === "unprocess" || $response->confession->status === "process") {
      $page = $response->page;
      unset($response->page);
      $rules = $this->rules;
      unset($rules["status"]);

      $credentials = Validator::make($data, $rules, $this->messages)->validate();

      $confession = RecConfession::where("id_confession", $response->id_confession)->first();
      $credentials = $this->file($response->attachment_file, $credentials, "attachment_file", "confession/response/attachment-files");

      return $this->modify($response, $credentials, $user->id_user, "tanggapan", $this->createResponsesURLWithParam($confession->slug) . base64_encode($response->id_confession_response) . "&page=$page");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa editing tanggapan ketika status confession bukan "unprocess" atau "process".');
  }

  private function officerDestroy(User $user, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);
      $this->isSystemResponse($response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess" || $response->confession->status === "process") {
        if (!HistoryConfessionResponse::destroy($response->id_confession_response)) throw new \Exception('Error unsend response.');
        $response->update(["updated_by" => $user->id_user]);
        if ($response->attachment_file) Storage::delete($response->attachment_file);
      } else return $this->responseJsonMessage("Kamu tidak bisa melakukan unsend ketika status confession bukan 'unprocess' atau 'process'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Tanggapan kamu berhasil di-unsend!");
  }

  public function officerExport(string $table, string $fileName, $writterType, User $user)
  {
    if ($table === "all-of-responses")
      return $this->exports((new AllOfResponsesExport), $fileName, $writterType);
    if ($table === "your-responses")
      return $this->exports((new YourResponsesExport)->forIdUser($user->id_user), $fileName, $writterType);

    return view("errors.404");
  }

  private function officerDestroyAttachment(User $user, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess" || $response->confession->status === "process") {
        if (!Storage::delete($response->attachment_file)) throw new \Exception('Error unsend attachment file.');
        $response->update(["attachment_file" => null, "updated_by" => $user->id_user]);
      } else return $this->responseJsonMessage("Kamu tidak bisa unsend file pendukung ketika status confession bukan 'unprocess' atau 'process'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("File pendukung berhasil di-unsend.");
  }


  // STUDENT
  private function studentIndex(User $user)
  {
    $yourResponses = HistoryConfessionResponse::with([
      "confession",
    ])
      ->where("id_user", $user->id_user)
      ->where("system_response", "N")
      ->latest()
      ->paginateResponsesFromConfession(self::PER_PAGE);

    $viewVariables = [
      "title" => "Tanggapan",
      "yourResponses" => $yourResponses,
    ];
    return view("pages.dashboard.actors.student.responses.index", $viewVariables);
  }

  private function studentCreate(User $user,  RecConfession $confession)
  {
    try {
      $this->isYourConfession($user, $confession);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    $sortedResponses = HistoryConfessionResponse::with(["user"])
      ->where("id_confession", $confession->id_confession)
      ->latest()
      ->paginate(self::PER_PAGE);

    $viewVariables = [
      "title" => ucwords($confession->title),
      "confession" => $confession,
      "responses" => $sortedResponses,
    ];
    return view("pages.dashboard.actors.student.responses.create", $viewVariables);
  }

  private function studentStore($data, User $user,  RecConfession $confession)
  {
    try {
      $this->isYourConfession($user, $confession);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess" || $confession->status === "process") {
      $rules = $this->rules;
      unset($rules["status"]);

      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials = $this->file(null, $credentials, "attachment_file", "confession/response/attachment-files");
      $optFields = ["attachment_file" => $credentials["attachment_file"] ?? null];
      $response = HistoryConfessionResponse::setResponse($user, $confession, $credentials["response"], $confession->status, "N", $optFields);

      return redirect($this->createResponsesURLWithParam($confession->slug) . base64_encode($response->id_confession_response))->withSuccess("Tanggapan kamu berhasil dibuat.");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa memberikan tanggapan ketika status confession bukan "unprocess" atau "process".');
  }

  private function studentEdit(User $user, RecConfession $confession, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($confession->status === "unprocess") {
      $viewVariables = [
        "title" => "Sunting Tanggapan",
        "response" => $response,
        "confession" => $confession,
      ];
      return view("pages.dashboard.actors.student.responses.edit", $viewVariables);
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa sunting tanggapan ketika status confession bukan "unprocess".');
  }

  private function studentUpdate($data, User $user, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    // ---------------------------------
    // Rules
    if ($response->confession->status === "unprocess") {
      $page = $response->page;
      unset($response->page);
      $rules = $this->rules;
      unset($rules["status"]);

      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials = $this->file($response->attachment_file, $credentials, "attachment_file", "confession/response/attachment-files");

      return $this->modify($response, $credentials, $user->id_user, "tanggapan", $this->createResponsesURLWithParam($response->confession->slug) . base64_encode($response->id_confession_response) . "&page=$page");
    }

    return redirect(self::HOME_URL)->withErrors('Kamu tidak bisa memberikan tanggapan ketika status confession bukan "unprocess".');
  }

  private function studentDestroy(User $user, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);
      $this->isSystemResponse($response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess") {
        if (!HistoryConfessionResponse::destroy($response->id_confession_response)) throw new \Exception('Error unsend response.');
        $response->update(["updated_by" => $user->id_user]);
        if ($response->attachment_file) Storage::delete($response->attachment_file);
      } else return $this->responseJsonMessage("Kamu tidak bisa melakukan unsend ketika status confession bukan 'unprocess'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Tanggapan kamu telah di-unsend!");
  }

  public function studentExport(string $table, string $fileName, $writterType, User $user)
  {
    if ($table === "your-responses")
      return $this->exports((new YourResponsesExport)->forIdUser($user->id_user), $fileName, $writterType);

    return view("errors.404");
  }

  private function studentDestroyAttachment(User $user, HistoryConfessionResponse $response)
  {
    try {
      $this->isYourResponse($user, $response);

      // ---------------------------------
      // Rules
      if ($response->confession->status === "unprocess") {
        if (!Storage::delete($response->attachment_file)) throw new \Exception('Error unsend attachment file.');
        $response->update(["attachment_file" => null, "updated_by" => $user->id_user]);
      } else return $this->responseJsonMessage("Kamu tidak bisa unsend file pendukung ketika status confession bukan 'unprocess' atau 'process'.", 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("File pendukung kamu telah di-unsend!");
  }
}
