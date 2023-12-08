<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\{Validator, Hash, Storage};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{HistoryLogin, MasterRole, User};
use App\Models\Traits\{Exportable, Importable};
use App\Models\Traits\Helpers\{Accountable, Loginable};
use App\Exports\Users\{AllOfUsersExport, HistoryLoginsExport};
use App\Exports\Users\Templates\{UsersExport};
use App\Imports\Users\{UsersImport};

class UserService extends Service
{
  // ---------------------------------
  // TRAITS
  use Loginable, Accountable, Exportable, Importable;


  // ---------------------------------
  // PROPERTIES
  protected array $rules = [
    "profile_picture" => ["image", "file", "max:5120"],
    "full_name" => ["required", "max:255"],
    "username" => ["required", "unique:mst_users,username", "min:3", "max:30"],
    "nik" => ["required", "digits:16", "string", "unique:mst_users,nik"],
    "nip" => ["required", "digits:18", "string", "unique:dt_officers,nip"],
    "nisn" => ["required", "digits:10", "string", "unique:dt_students,nisn"],
    "email" => ["nullable", "unique:mst_users,email", "email:rfc,dns"],
    "gender" => ['required'],
    'password' => ['required', 'confirmed', 'min:6'],
    'password_confirmation' => ['required', 'min:6', "required_with:password", "same:password"],
  ];

  protected array $settingRules = [
    "profile_picture" => ["image", "file", "max:5120"],
    "full_name" => ["required", "max:255"],
    "username" => ["required", "unique:mst_users,username", "min:3", "max:30"],
    "nik" => ["required", "digits:16", "string"],
    "nip" => ["required", "digits:18", "string"],
    "nisn" => ["required", "digits:10", "string"],
    "email" => ["nullable", "unique:mst_users,email", "email:rfc,dns"],
  ];

  protected array $numberingRules = [
    "nik" => ["nullable", "numeric"],
    "nip" => ["nullable", "numeric"],
    "nisn" => ["nullable", "numeric"],
  ];

  protected array $messages = [
    "profile_picture.image" => "Foto profil harus berupa gambar.",
    "profile_picture.file" => "Foto profil harus berupa file.",
    "profile_picture.max" => "Foto profil tidak boleh lebih dari :max KiB.",
    "full_name.required" => "Nama lengkap tidak boleh kosong.",
    "full_name.max" => "Nama lengkap tidak boleh lebih dari :max karakter.",
    "username.required" => "Username tidak boleh kosong.",
    "username.unique" => "Username sudah digunakan.",
    "username.min" => "Username tidak boleh kurang dari :min karakter.",
    "username.max" => "Username tidak boleh lebih dari :max karakter.",
    "nik.required" => "NIK tidak boleh kosong.",
    "nik.digits" => "NIK harus :digits karakter.",
    "nik.numeric" => "NIK harus berupa angka.",
    "nip.required" => "NIP tidak boleh kosong.",
    "nip.digits" => "NIP harus :digits karakter.",
    "nip.numeric" => "NIP harus berupa angka.",
    "nisn.required" => "NISN tidak boleh kosong.",
    "nisn.digits" => "NISN harus :digits karakter.",
    "nisn.numeric" => "NISN harus berupa angka.",
    "email.unique" => "Email sudah digunakan.",
    "email.email" => "Email harus valid.",
    "gender.required" => "Jenis kelamin tidak boleh kosong.",
    "password.required" => "Password tidak boleh kosong.",
    "password.confirmed" => "Password tidak cocok.",
    "password.min" => "Password tidak boleh kurang dari :min karakter.",
    "password_confirmation.required" => "Konfirmasi password tidak boleh kosong.",
    "password_confirmation.min" => "Konfirmasi password tidak boleh kurang dari :min karakter.",
    "password_confirmation.required_with" => "Konfirmasi password tidak boleh kosong.",
    "password_confirmation.same" => "Konfirmasi password tidak cocok.",
    "role_name.required" => "Role tidak boleh kosong.",
  ];


  // ---------------------------------
  // HELPERS
  public function validateNumbering($data)
  {
    return Validator::make($data, $this->numberingRules, $this->messages)->validate();
  }

  public function validateChangePassword(User $user, $currentPassword, $newPassword)
  {
    $this->checkCurrentPassword($user, $currentPassword);
    $this->checkSamePassword($currentPassword, $newPassword);
  }


  // ---------------------------------
  // CORES
  public function index(User $user, MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex($user);

    return view("errors.403");
  }

  public function register(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminRegister();

    return view("errors.403");
  }

  public function store(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminStore($data, $user);

    return view("errors.403");
  }

  public function show(User $user, MasterRole $userRole, User $theUser)
  {
    // Data processing
    $theUser = User::with(["userRole.role", "student", "officer"])->where("username", $theUser->username)->first();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminShow($user, $theUser);

    return view("errors.403");
  }

  public function edit(MasterRole $userRole, User $theUser)
  {
    // Data processing
    $theUser = User::with(["userRole.role", "student", "officer"])->where("username", $theUser->username)->first();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminEdit($theUser);

    return view("errors.403");
  }

  public function update(Request $request, User $user, MasterRole $userRole, User $theUser)
  {
    // Data processing
    $data = $request->all();
    $theUser = User::with(["userRole.role", "student", "officer"])->where("username", $theUser->username)->first();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminUpdate($data, $user, $theUser);

    return view("errors.403");
  }

  public function destroy(User $user, MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $theUser = User::with(["userRole.role"])->where("id_user", $id)->first();
    if (!$theUser) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroy($user, $theUser);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function export(Request $request, MasterRole $userRole)
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

    return view("errors.403");
  }

  public function exportTemplate(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();
    $validator = $this->exportValidates($data);
    if ($validator->fails()) return view("errors.403");
    $creds = $validator->validate();

    $fileName = $this->getExportFileName($creds["type"]);
    $writterType = $this->getWritterType($creds["type"]);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminExportTemplate($creds["table"], $fileName, $writterType);

    return view("errors.403");
  }

  public function import(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();
    $validator = $this->importValidates($data);
    if ($validator->fails()) return back()->withErrors($validator->messages());
    $creds = $validator->validate();

    $extFile = strtoupper($creds["file"]->getClientOriginalExtension());
    $writterType = $this->getWritterType($extFile);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminImport($creds["table"], $creds["file"], $writterType);

    return view("errors.403");
  }

  public function profile(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName) {
      $viewVariables = [
        "title" => "Profil",
      ];
      return view("pages.dashboard.actors.custom.account.profile", $viewVariables);
    }

    return view("errors.403");
  }

  public function settings(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminSettings();
    if ($roleName === "officer") return $this->officerSettings();
    if ($roleName === "student") return $this->studentSettings();

    return view("errors.403");
  }

  public function settingsUpdate(Request $request, User $user, MasterRole $userRole, $userUnique, User $yourAccount)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminSettingsUpdate($data, $user, $userUnique, $yourAccount);
    if ($roleName === "officer") return $this->officerSettingsUpdate($data, $user, $yourAccount);
    if ($roleName === "student") return $this->studentSettingsUpdate($data, $user, $yourAccount);

    return view("errors.403");
  }

  public function changePassword(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName) {
      $viewVariables = [
        "title" => "Ganti Password",
      ];
      return view("pages.dashboard.actors.custom.account.change-password", $viewVariables);
    }

    return view("errors.403");
  }

  public function changePasswordUpdate(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName) {
      $arr = $this->getRulesMessagesPassword();
      $credentials = Validator::make($data, $arr["rules"], $arr["messages"])->validate();

      try {
        $this->validateChangePassword($user, $credentials["current_password"], $credentials["new_password"]);
      } catch (\Exception $e) {
        return redirect("/dashboard/users/account/password")->withErrors($e->getMessage());
      }

      return $this->alterYourPassword($user, $credentials);
    }

    return view("errors.403");
  }

  public function destroyProfilePicture(User $user, MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $yourAccount = User::where("id_user", $id)->first();
    if (!$yourAccount->profile_picture) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroyProfilePicture($yourAccount);
    if ($roleName === "officer") return $this->officerDestroyProfilePicture($user, $yourAccount);
    if ($roleName === "student") return $this->studentDestroyProfilePicture($user, $yourAccount);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function activate(User $user, MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $theUser = User::with(["userRole.role", "officer.confessions", "student"])->where("id_user", $id)->first();
    if (!$theUser) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminActivate($user, $theUser);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function nonActiveYourAccount(MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $yourAccount = User::with(["userRole.role.anotherUsersBasedYourRole"])->where("id_user", $id)->first();
    if (!$yourAccount) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminNonActiveYourAccount($yourAccount);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function historyLogins(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminHistoryLogins();

    return view("errors.403");
  }

  public function role(User $user, MasterRole $userRole, User $theUser)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminRole($user, $theUser);

    return view("errors.403");
  }

  public function roleUpdate(Request $request, User $user, MasterRole $userRole, User $theUser)
  {
    // Data processing
    $data = $request->all();
    $theUser = User::with(["userRole.role"])->where("id_user", $theUser->id_user)->first();
    if (!$theUser) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminRoleUpdate($data, $user, $theUser);

    return view("errors.403");
  }

  public function mutateUserPassword(Request $request, MasterRole $userRole, User $theUser)
  {
    // Data processing
    $data = $request->all();
    $theUser = User::where("id_user", $theUser->id_user)->first();
    if (!$theUser) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminMutateUserPassword($data, $theUser);

    return view("errors.403");
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  public function adminIndex(User $user)
  {
    $users = User::with("userRole.role")
      ->whereNot("id_user", $user->id_user)
      ->latest()
      ->get();

    $viewVariables = [
      "title" => "Pengguna",
      "users" => $users,
    ];
    return view("pages.dashboard.actors.admin.users.all", $viewVariables);
  }

  public function adminRegister()
  {
    $roles = MasterRole::all();

    $viewVariables = [
      "title" => "Tambah Pengguna",
      "roles" => $roles,
    ];
    return view("pages.dashboard.actors.admin.users.register", $viewVariables);
  }

  public function adminStore($data, User $user)
  {
    $rules = $this->rules;
    $rules["role"] = ["required"];
    if (!array_key_exists("nip", $data)) unset($rules["nip"]);
    if (!array_key_exists("nisn", $data)) unset($rules["nisn"]);

    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials["password"] = Hash::make($credentials["password"]);
    $credentials = $this->imageCropping(null, $credentials, "profile_picture", "user/profile-pictures");
    $credentials["role"] = MasterRole::where("role_name", $credentials["role"])->value("id_role");
    $credentials["created_by"] = $user->id_user;

    $theUser = User::create($credentials);
    $theUser = $this->createRoleUser($theUser, $credentials);
    $theUser = $this->createUniqueUser($theUser, $data["role"], $credentials);

    return redirect("/dashboard/users/details/$theUser->username")->withSuccess("Pengguna @$theUser->username berhasil diregistrasi!");
  }

  public function adminShow(User $user, User $theUser)
  {
    try {
      $this->isNotYourAccount($user, $theUser);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    $viewVariables = [
      "title" => "Pengguna $theUser->username",
      "theUser" => $theUser,
    ];
    return view("pages.dashboard.actors.admin.users.show", $viewVariables);
  }

  public function adminEdit(User $theUser)
  {
    $theUserRole = $theUser->userRole->role->role_name;

    // ---------------------------------
    // Rules
    if ($theUserRole !== "admin") {
      $roles = MasterRole::all();

      $viewVariables = [
        "title" => "Edit Pengguna",
        "roles" => $roles,
        "theUser" => $theUser,
      ];
      return view("pages.dashboard.actors.admin.users.edit", $viewVariables);
    }

    return redirect(self::HOME_URL)
      ->withErrors('Kamu tidak bisa menyunting akun admin.');
  }

  public function adminUpdate($data, User $user, User $theUser)
  {
    $theUserRole = $theUser->userRole->role->role_name;

    // ---------------------------------
    // Rules
    if ($theUserRole !== "admin") {
      $rules = $this->updateUserRules($this->rules, $theUser, $data);

      $this->validateNumbering($data);
      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials = $this->imageCropping($theUser->profile_picture, $credentials, "profile_picture", "user/profile-pictures");

      return $this->updateUserUniqueAndRole($user, $theUser, $credentials);
    }

    return redirect(self::HOME_URL)
      ->withErrors('Kamu tidak bisa menyunting akun admin.');
  }

  public function adminDestroy(User $user, User $theUser)
  {
    $theUserRole = $theUser->userRole->role->role_name;

    try {
      // ---------------------------------
      // Rules
      if ($theUserRole !== "admin") {
        if (!$theUser->update(["updated_by" => $user->id_user, "flag_active" => "N", "deleted_at" => null]))
          throw new \Exception("Error deactivating the user.");
      } else return $this->responseJsonMessage('Kamu tidak bisa menonaktifkan akun admin.', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Exception $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Pengguna @$theUser->username berhasil dinonaktifkan.");
  }

  public function adminExport(string $table, string $fileName, $writterType)
  {
    if ($table === "all-of-users")
      return $this->exports((new AllOfUsersExport), $fileName, $writterType);
    if ($table === "history-logins")
      return $this->exports((new HistoryLoginsExport), $fileName, $writterType);

    return view("errors.404");
  }

  public function adminExportTemplate(string $table, string $fileName, $writterType)
  {
    if ($table === "users-template")
      return $this->exports(new UsersExport, $fileName, $writterType);

    return view("errors.404");
  }

  public function adminImport(string $table, $file, $writterType)
  {
    if ($table === "users-import")
      return $this->imports(new UsersImport, $file, $writterType, "Data pengguna berhasil di-import!");

    return view("errors.404");
  }

  public function adminSettings()
  {
    $viewVariables = [
      "title" => "Pengaturan",
    ];
    return view("pages.dashboard.actors.admin.account.settings", $viewVariables);
  }

  public function adminSettingsUpdate($data, User $user, $userUnique, User $yourAccount)
  {
    try {
      $this->isYourAccount($user, $yourAccount);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    $rules = $this->settingRules;
    unset($rules["nisn"]);
    if ($data["username"] === $yourAccount->username) unset($rules["username"]);
    if ($data["email"] === $yourAccount->email) unset($rules["email"]);
    if ($data["nik"] === $yourAccount->nik) unset($rules["nik"]);
    if ($data["nip"] === $userUnique->nip) unset($rules["nip"]);

    $this->validateNumbering($data);
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($yourAccount->profile_picture, $credentials, "profile_picture", "user/profile-pictures");

    if (array_key_exists("nip", $credentials))
      $userUnique->update([
        "nip" => $credentials["nip"],
        "updated_by" => $user->id_user,
      ]);

    $credentials["updated_by"] = $user->user_id;
    $yourAccount->update($credentials);

    return redirect("/dashboard/users/account")->withSuccess("Akun kamu berhasil disunting!");
  }

  public function adminDestroyProfilePicture($yourAccount)
  {
    try {
      if (!Storage::delete($yourAccount->profile_picture)) throw new \Exception('Error deleting profile picture.');
      $yourAccount->update(["profile_picture" => null, "updated_by" => $yourAccount->id_user]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Foto profil berhasil dihapus.");
  }

  public function adminActivate(User $user, User $theUser)
  {
    $theUserRole = $theUser->userRole->role->role_name;

    try {
      // ---------------------------------
      // Rules
      if ($theUserRole !== "admin") {
        if (!$theUser->update(["updated_by" => $user->id_user, "flag_active" => "Y", "deleted_at" => null]))
          throw new \Exception("Error activating the user.");;
      } else return $this->responseJsonMessage('Kamu tidak bisa mengaktifkan akun admin.', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Exception $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Pengguna @$theUser->username berhasil diaktifkan.");
  }

  public function adminNonActiveYourAccount(User $yourAccount)
  {
    try {
      // ---------------------------------
      // Rules
      if ($yourAccount->userRole->role->anotherUsersBasedYourRole->count() === 1)
        throw new \Exception("Kamu tidak bisa menonaktifkan akun karena kamu adalah admin terakhir!");
      if (!$yourAccount->update(["flag_active" => "N", "deleted_at" => null]))
        throw new \Exception("Error deactivating the user.");
      $this->breakUserSession();
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Exception $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Akun kamu berhasil dinonaktifkan.");
  }

  public function adminHistoryLogins()
  {
    $historyLogins = HistoryLogin::latest()->get();

    $viewVariables = [
      "title" => "Riwayat Login",
      "historyLogins" => $historyLogins,
    ];
    return view("pages.dashboard.actors.admin.users.history-logins", $viewVariables);
  }

  public function adminRole(User $user, User $theUser)
  {
    try {
      $this->isNotYourAccount($user, $theUser);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    $theUserRole = $theUser->userRole->role->role_name;

    // ---------------------------------
    // Rules
    if ($theUserRole === "admin") {
      $roles = MasterRole::all();

      $viewVariables = [
        "title" => "Ganti Role",
        "roles" => $roles,
        "theUser" => $theUser,
      ];
      return view("pages.dashboard.actors.admin.users.role", $viewVariables);
    }

    return redirect(self::HOME_URL)->withErrors("$theUser->full_name bukan admin.");
  }

  public function adminRoleUpdate($data, User $user, User $theUser)
  {
    try {
      $this->isNotYourAccount($user, $theUser);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    $theUserRole = $theUser->userRole->role->role_name;
    $inputRole = $data["role"];

    // ---------------------------------
    // Rules
    if ($theUserRole === "admin") {
      $rules["nip"] = $this->rules["nip"];
      $rules["role"] = ["required"];

      if ($data["nip"] === $theUser->officer->nip) {
        unset($rules['nip']);

        $this->validateNumbering($data);
        $credentials = Validator::make($data, $rules, $this->messages)->validate();
        $credentials["role"] = MasterRole::where("role_name", $credentials["role"])->value("id_role");

        if (array_key_exists("nip", $credentials))
          $theUser->officer()->update([
            "nip" => $credentials["nip"],
            "updated_by" => $user->id_user,
          ]);

        if ($theUserRole !== $inputRole)
          $theUser->userRole()->update(["id_role" => $credentials["role"]]);

        $theUser->refresh();
        return redirect("/dashboard/users")->withSuccess("Role pengguna @$theUser->username berhasil diubah menjadi " . ucwords($theUser->userRole->role->role_name) . ".");
      }

      return redirect(self::HOME_URL)->withErrors("Kamu tidak bisa memanipulasi unik pengguna.");
    }

    return redirect(self::HOME_URL)->withErrors("$theUser->full_name bukan admin.");
  }

  public function adminMutateUserPassword($data, User $theUser)
  {
    $arr = $this->getRulesMessagesPassword(false, true);
    $credentials = Validator::make($data, $arr["rules"], $arr["messages"])->validate();

    return $this->alterYourPassword($theUser, $credentials, "/dashboard/users/details/$theUser->username", "Password @$theUser->username berhasil diganti!");
  }


  // OFFICER
  public function officerSettings()
  {
    $viewVariables = [
      "title" => "Pengaturan",
    ];
    return view("pages.dashboard.actors.officer.account.settings", $viewVariables);
  }

  public function officerSettingsUpdate($data, User $user, User $yourAccount)
  {
    try {
      $this->isYourAccount($user, $yourAccount);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    $rules = $this->settingRules;
    unset($rules["nik"], $rules["nip"], $rules["nisn"], $rules["full_name"]);
    if ($data["username"] === $yourAccount->username) unset($rules["username"]);
    if ($data["email"] === $yourAccount->email) unset($rules["email"]);

    $this->validateNumbering($data);
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($yourAccount->profile_picture, $credentials, "profile_picture", "user/profile-pictures");

    return $this->modify($yourAccount, $credentials, $user->id_user, "akunmu", "/dashboard/users/account");
  }

  public function officerDestroyProfilePicture(User $user, $yourAccount)
  {
    try {
      $this->isYourAccount($user, $yourAccount);

      if (!Storage::delete($yourAccount->profile_picture)) throw new \Exception('Error deleting profile picture.');
      $yourAccount->update(["profile_picture" => null, "updated_by" => $yourAccount->id_user]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Foto profil berhasil dihapus.");
  }


  // STUDENT
  public function studentSettings()
  {
    $viewVariables = [
      "title" => "Pengaturan",
    ];
    return view("pages.dashboard.actors.student.account.settings", $viewVariables);
  }

  public function studentSettingsUpdate($data, User $user, User $yourAccount)
  {
    try {
      $this->isYourAccount($user, $yourAccount);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    $rules = $this->settingRules;
    unset($rules["nik"], $rules["nisn"], $rules["nip"], $rules["full_name"]);
    if ($data["username"] === $yourAccount->username) unset($rules["username"]);
    if ($data["email"] === $yourAccount->email) unset($rules["email"]);

    $this->validateNumbering($data);
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($yourAccount->profile_picture, $credentials, "profile_picture", "user/profile-pictures");

    return $this->modify($yourAccount, $credentials, $user->id_user, "akunmu", "/dashboard/users/account");
  }

  public function studentDestroyProfilePicture(User $user, $yourAccount)
  {
    try {
      $this->isYourAccount($user, $yourAccount);

      if (!Storage::delete($yourAccount->profile_picture)) throw new \Exception('Error deleting profile picture.');
      $yourAccount->update(["profile_picture" => null, "updated_by" => $yourAccount->id_user]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Foto profil berhasil dihapus.");
  }
}