<?php

namespace App\Services\Dashboard;

use App\Models\{HistoryLogin, MasterRole, User};
use App\Models\Traits\Helpers\Accountable;
use App\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\{Auth, Hash, Storage};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class UserService extends Service
{
  // ---------------------------------
  // TRAITS
  use Accountable;


  // ---------------------------------
  // PROPERTIES
  protected array $rules = [
    "profile_picture" => ["image", "file", "max:5120"],
    "full_name" => ["required", "max:255"],
    "username" => ["required", "unique:mst_users,username", "min:3", "max:30"],
    "nik" => ["required", "size:16", "string", "unique:mst_users,nik"],
    "nip" => ["required", "size:18", "string", "unique:dt_officers,nip"],
    "nisn" => ["required", "size:10", "string", "unique:dt_students,nisn"],
    "email" => ["nullable", "unique:mst_users,email", "email:rfc,dns"],
    "gender" => ['required'],
    'password' => ['required', 'confirmed', 'min:6'],
    'password_confirmation' => ['required', 'min:6', "required_with:password", "same:password"],
  ];

  protected array $settingRules = [
    "profile_picture" => ["image", "file", "max:5120"],
    "full_name" => ["required", "max:255"],
    "username" => ["required", "unique:mst_users,username", "min:3", "max:30"],
    "nik" => ["required", "size:16", "string"],
    "nip" => ["required", "size:18", "string"],
    "nisn" => ["required", "size:10", "string"],
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
    "nik.size" => "NIK harus :size karakter.",
    "nik.numeric" => "NIK harus berupa angka.",
    "nip.required" => "NIP tidak boleh kosong.",
    "nip.size" => "NIP harus :size karakter.",
    "nip.numeric" => "NIP harus berupa angka.",
    "nisn.required" => "NISN tidak boleh kosong.",
    "nisn.size" => "NISN harus :size karakter.",
    "nisn.numeric" => "NISN harus berupa angka.",
    "email.unique" => "Email sudah digunakan.",
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
  // CORES  
  public function validateNumbering($data)
  {
    return Validator::make($data, $this->numberingRules, $this->messages)->validate();
  }


  // ---------------------------------
  // CORES
  public function index(User $user, MasterRole $userRole)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex($user);

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function register(MasterRole $userRole)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminRegister();

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function store(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminStore($data, $user);

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function show(MasterRole $userRole, User $theUser)
  {
    // Data processing
    $theUser = User::with(["userRole.role", "student", "officer"])->where("username", $theUser->username)->first();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminShow($theUser);

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function edit(MasterRole $userRole, User $theUser)
  {
    // Data processing
    $theUser = User::with(["userRole.role", "student", "officer"])->where("username", $theUser->username)->first();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminEdit($theUser);

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function update(Request $request, User $user, MasterRole $userRole, User $theUser)
  {
    // Data processing
    $data = $request->all();
    $theUser = User::with(["userRole.role", "student", "officer"])->where("username", $theUser->username)->first();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminUpdate($data, $user, $theUser);

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function destroy(User $user, MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $theUser = User::with(["userRole.role"])->where("id_user", $id)->first();
    if (!$theUser) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroy($user, $theUser);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }
  public function activate(User $user, MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $theUser = User::with(["userRole.role", "officer.confessions", "student"])->where("id_user", $id)->first();
    if (!$theUser) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminActivate($user, $theUser);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }
  public function profile()
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Profil",
    ];
    return view("pages.dashboard.actors.custom.account.profile", $viewVariables);
  }
  public function settings(MasterRole $userRole)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminSettings();
    if ($roleName === "officer") return $this->officerSettings();
    if ($roleName === "student") return $this->studentSettings();

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function settingsUpdate(Request $request, User $user, MasterRole $userRole, $userUnique, User $yourAccount)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminSettingsUpdate($data, $user, $userUnique, $yourAccount);
    if ($roleName === "officer") return $this->officerSettingsUpdate($data, $user, $yourAccount);
    if ($roleName === "student") return $this->studentSettingsUpdate($data, $user, $yourAccount);

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function destroyProfilePicture(User $user, MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $yourAccount = User::where("id_user", $id)->first();
    if (!$yourAccount->profile_picture) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroyProfilePicture($yourAccount);
    if ($roleName === "officer") return $this->officerDestroyProfilePicture($user, $yourAccount);
    if ($roleName === "student") return $this->studentDestroyProfilePicture($user, $yourAccount);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }
  public function historyLogins(MasterRole $userRole)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminHistoryLogins();

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function nonActiveYourAccount(MasterRole $userRole, $idUser)
  {
    // Data processing
    $id = $this->idDecrypted($idUser);
    $yourAccount = User::with(["userRole.role.anotherUsersBasedYourRole"])->where("id_user", $id)->first();
    if (!$yourAccount) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminNonActiveYourAccount($yourAccount);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }
  public function role(MasterRole $userRole, User $theUser)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminRole($theUser);

    // Redirect to unauthorized page
    return view("errors.403");
  }
  public function roleUpdate(Request $request, User $user, MasterRole $userRole, User $theUser)
  {
    // Data processing
    $data = $request->all();
    $theUser = User::with(["userRole.role"])->where("id_user", $theUser->id_user)->first();
    if (!$theUser) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminRoleUpdate($data, $user, $theUser);

    // Redirect to unauthorized page
    return view("errors.403");
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  // Index
  public function adminIndex(User $user)
  {
    // Data processing
    $users = User::with("userRole.role")
      ->whereNot("id_user", $user->id_user)
      ->latest()
      ->get();

    // Passing out a view
    $viewVariables = [
      "title" => "Pengguna",
      "users" => $users,
    ];
    return view("pages.dashboard.actors.admin.users.all", $viewVariables);
  }
  // Register
  public function adminRegister()
  {
    // Data processing
    $roles = MasterRole::all();

    // Passing out a view
    $viewVariables = [
      "title" => "Tambah Pengguna",
      "roles" => $roles,
    ];
    return view("pages.dashboard.actors.admin.users.register", $viewVariables);
  }
  // Store
  public function adminStore($data, User $user)
  {
    // Rules
    $rules = $this->rules;
    $rules["role"] = ["required"];
    if (!array_key_exists("nip", $data)) unset($rules["nip"]);
    if (!array_key_exists("nisn", $data)) unset($rules["nisn"]);

    // Validates
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials["password"] = Hash::make($credentials["password"]);
    $credentials = $this->imageCropping(null, $credentials, "profile_picture", "user/profile-pictures");
    $credentials["role"] = MasterRole::where("role_name", $credentials["role"])->value("id_role");
    $credentials["created_by"] = $user->id_user;

    // Create the user
    $theUser = User::create($credentials);
    $theUser = $this->createRoleUser($theUser, $credentials);
    $theUser = $this->createUniqueUser($theUser, $data["role"], $credentials);

    // Success
    return redirect("/dashboard/users/details/$theUser->username")->withSuccess("Pengguna @$theUser->username berhasil diregistrasi!");
  }
  // Show
  public function adminShow(User $theUser)
  {
    // Passing out a view
    $viewVariables = [
      "title" => "$theUser->username",
      "user" => $theUser,
    ];
    return view("pages.dashboard.actors.admin.users.show", $viewVariables);
  }
  // Edit
  public function adminEdit(User $theUser)
  {
    // ---------------------------------
    // Rules
    if ($theUser->userRole->role->role_name !== "admin") {
      $roles = MasterRole::all();

      // Passing out a view
      $viewVariables = [
        "title" => "Edit Pengguna",
        "roles" => $roles,
        "user" => $theUser,
      ];
      return view("pages.dashboard.actors.admin.users.edit", $viewVariables);
    }

    return redirect(self::HOME_URL)
      ->withErrors('Kamu tidak bisa menyunting akun admin.');
  }
  // Update
  public function adminUpdate($data, User $user, User $theUser)
  {
    $theUserRole = $theUser->userRole->role->role_name;

    // ---------------------------------
    // Rules
    if ($theUserRole !== "admin") {
      // Rules
      $rules = $this->rules;
      if ($theUserRole === "officer") $rules['role'] = ["required"];
      unset($rules["password"], $rules["password_confirmation"]);
      if ($data["username"] === $theUser->username) unset($rules["username"]);
      if ($data["email"] === $theUser->email) unset($rules["email"]);
      if ($data["nik"] === $theUser->nik) unset($rules["nik"]);
      if (!array_key_exists("nip", $data)) unset($rules["nip"]);
      if (!array_key_exists("nisn", $data)) unset($rules["nisn"]);
      if (array_key_exists("nip", $data)) if ($data["nip"] === $theUser->officer?->nip) unset($rules["nip"]);
      if (array_key_exists("nisn", $data)) if ($data["nisn"] === $theUser->student?->nisn) unset($rules["nisn"]);

      // Validates
      $this->validateNumbering($data);
      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials = $this->imageCropping($theUser->profile_picture, $credentials, "profile_picture", "user/profile-pictures");
      $credentials["updated_by"] = $user->id_user;
      if ($theUserRole === "officer") {
        $role = $credentials["role"];
        $credentials["role"] = MasterRole::where("role_name", $role)->value("id_role");
      };

      // Update the user
      $theUser->update($credentials);

      if ($theUserRole === "officer" && array_key_exists("nip", $credentials)) {
        $theUser->officer()->update([
          "nip" => $credentials["nip"],
          "updated_by" => $user->id_user,
        ]);
      }

      if ($theUserRole !== $role) {
        $theUser->userRole()->update(["id_role" => $credentials["role"]]);
        $theUser->refresh();
      }

      if ($theUserRole === "student" && array_key_exists("nisn", $credentials)) {
        $theUser->student()->update([
          "nisn" => $credentials["nisn"],
          "updated_by" => $user->id_user,
        ]);
      }

      // Success
      return redirect("/dashboard/users")->withSuccess("Pengguna berhasil diubah.");
    }

    return redirect(self::HOME_URL)
      ->withErrors('Kamu tidak bisa menyunting akun admin.');
  }
  // Destroy
  public function adminDestroy(User $user, User $theUser)
  {
    try {
      // ---------------------------------
      // Rules
      if ($theUser->userRole->role->role_name !== "admin") {
        // Destroy the user
        if (!User::destroy($theUser->id_user)) throw new \Exception("Error deleting the user.");
        // Non-active data and updated by
        $theUser->refresh();
        $theUser->update(["updated_by" => $user->id_user, "flag_active" => "N", "deleted_at" => null]);
      } else return $this->responseJsonMessage('Kamu tidak bisa menonaktifkan akun admin.', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Exception $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Pengguna berhasil dinonaktifkan.");
  }
  // Activate
  public function adminActivate(User $user, User $theUser)
  {
    try {
      // ---------------------------------
      // Rules
      if ($theUser->userRole->role->role_name !== "admin") {
        // Activate the user
        $theUser->update(["updated_by" => $user->id_user, "flag_active" => "Y", "deleted_at" => null]);
      } else return $this->responseJsonMessage('Kamu tidak bisa mengaktifkan akun admin.', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Exception $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Pengguna berhasil diaktifkan.");
  }
  // Settings
  public function adminSettings()
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Pengaturan",
    ];
    return view("pages.dashboard.actors.admin.account.settings", $viewVariables);
  }
  // Settings update
  public function adminSettingsUpdate($data, User $user, $userUnique, User $yourAccount)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourAccount($user, $yourAccount);
    } catch (\Exception $e) {
      return redirect("/dashboard/users/account")->withErrors($e->getMessage());
    }

    // Rules
    $rules = $this->settingRules;
    unset($rules["nisn"]);
    if ($data["username"] === $yourAccount->username) unset($rules["username"]);
    if ($data["email"] === $yourAccount->email) unset($rules["email"]);
    if ($data["nik"] === $yourAccount->nik) unset($rules["nik"]);
    if ($data["nip"] === $userUnique->nip) unset($rules["nip"]);

    // Validates
    $this->validateNumbering($data);
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($yourAccount->profile_picture, $credentials, "profile_picture", "user/profile-pictures");

    if (array_key_exists("nip", $credentials)) {
      $fields["nip"] = $credentials["nip"];
      return $this->modify($userUnique, $fields, $user->id_user, "akunmu", "/dashboard/users/account");
    }
    return $this->modify($yourAccount, $credentials, $user->id_user, "akunmu", "/dashboard/users/account");
  }
  // Destroy profile picture
  public function adminDestroyProfilePicture($yourAccount)
  {
    try {
      // Destroy the profile picture 
      if (!Storage::delete($yourAccount->profile_picture)) throw new \Exception('Error deleting profile picture.');
      // Update the profile picture and update by
      $yourAccount->update(["profile_picture" => null, "updated_by" => $yourAccount->id_user]);
      // Success
      return $this->responseJsonMessage("Foto profil berhasil dihapus.");
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }
  // History logins
  public function adminHistoryLogins()
  {
    // Data processing
    $historyLogins = HistoryLogin::latest()->get();

    // Passing out a view
    $viewVariables = [
      "title" => "Riwayat Login",
      "historyLogins" => $historyLogins,
    ];
    return view("pages.dashboard.actors.admin.users.history-logins", $viewVariables);
  }
  // Non-active your account
  public function adminNonActiveYourAccount(User $yourAccount)
  {
    try {
      // ---------------------------------
      // Rules
      if ($yourAccount->userRole->role->role_name === "admin") {
        if ($yourAccount->userRole->role->anotherUsersBasedYourRole->count() === 1) throw new \Exception("Kamu tidak bisa menonaktifkan akun karena kamu adalah admin terakhir!");
        // Destroy the user
        if (!User::destroy($yourAccount->id_user)) throw new \Exception("Error deleting the user.");
        // Non-active data and updated by
        $yourAccount->refresh();
        $yourAccount->update(["flag_active" => "N", "deleted_at" => null]);
        $this->breakUserSession();
      } else return $this->responseJsonMessage('Role kamu bukan admin. Hanya admin yang bisa menghapus akun.', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Exception $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Akun kamu berhasil dinonaktifkan.");
  }
  // Change role
  public function adminRole(User $theUser)
  {
    // ---------------------------------
    // Rules
    if ($theUser->userRole->role->role_name === "admin") {
      // Data processing
      $roles = MasterRole::all();

      // Passing out a view
      $viewVariables = [
        "title" => "Ganti Role",
        "roles" => $roles,
        "user" => $theUser,
      ];
      return view("pages.dashboard.actors.admin.users.role", $viewVariables);
    }

    return redirect(self::HOME_URL)->withErrors('User bukan admin.');
  }
  public function adminRoleUpdate($data, User $user, User $theUser)
  {
    $theUserRole = $theUser->userRole->role->role_name;

    // ---------------------------------
    // Rules
    if ($theUserRole === "admin") {
      $role = $data["role"];

      // Rules
      $rules = [];
      $rules["nip"] = $this->rules["nip"];
      $rules["role"] = ["required"];
      if ($data["nip"] === $theUser->officer->nip) unset($rules["nip"]);

      // Validates
      $this->validateNumbering($data);
      $credentials = Validator::make($data, $rules, $this->messages)->validate();
      $credentials["id_role"] = MasterRole::where("role_name", $credentials["role"])->value("id_role");

      if (array_key_exists("nip", $credentials)) {
        $fields["nip"] = $credentials["nip"];
        return $this->modify($theUser->officer, $fields, $theUser->id_user, "akun $theUser->full_name", "/dashboard/users");
      }

      // Success
      return $this->modify($theUser->userRole, $credentials, $theUser->id_user, "akun $theUser->full_name", "/dashboard/users");
    }

    return redirect(self::HOME_URL)->withErrors('User bukan admin.');
  }


  // OFFICER
  // Settings
  public function officerSettings()
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Pengaturan",
    ];
    return view("pages.dashboard.actors.officer.account.settings", $viewVariables);
  }
  // Settings update
  public function officerSettingsUpdate($data, User $user, User $yourAccount)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourAccount($user, $yourAccount);
    } catch (\Exception $e) {
      return redirect("/dashboard/users/account")->withErrors($e->getMessage());
    }

    // Rules
    $rules = $this->settingRules;
    unset($rules["nisn"], $rules["nik"]);
    if ($data["username"] === $yourAccount->username) unset($rules["username"]);
    if ($data["email"] === $yourAccount->email) unset($rules["email"]);

    // Validates
    $this->validateNumbering($data);
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($yourAccount->profile_picture, $credentials, "profile_picture", "user/profile-pictures");

    return $this->modify($yourAccount, $credentials, $user->id_user, "akunmu", "/dashboard/users/account");
  }
  // Destroy profile picture
  public function officerDestroyProfilePicture(User $user, $yourAccount)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourAccount($user, $yourAccount);
      // Destroy the profile picture 
      if (!Storage::delete($yourAccount->profile_picture)) throw new \Exception('Error deleting profile picture.');
      // Update the profile picture and update by
      $yourAccount->update(["profile_picture" => null, "updated_by" => $yourAccount->id_user]);
      // Success
      return $this->responseJsonMessage("Foto profil berhasil dihapus.");
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }


  // STUDENT
  // Settings
  public function studentSettings()
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Pengaturan",
    ];
    return view("pages.dashboard.actors.student.account.settings", $viewVariables);
  }
  // Settings update
  public function studentSettingsUpdate($data, User $user, User $yourAccount)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourAccount($user, $yourAccount);
    } catch (\Exception $e) {
      return redirect("/dashboard/users/account")->withErrors($e->getMessage());
    }

    // Rules
    $rules = $this->settingRules;
    unset($rules["nip"], $rules["nik"]);
    if ($data["username"] === $yourAccount->username) unset($rules["username"]);
    if ($data["email"] === $yourAccount->email) unset($rules["email"]);

    // Validates
    $this->validateNumbering($data);
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($yourAccount->profile_picture, $credentials, "profile_picture", "user/profile-pictures");

    return $this->modify($yourAccount, $credentials, $user->id_user, "akunmu", "/dashboard/users/account");
  }
  // Destroy profile picture
  public function studentDestroyProfilePicture(User $user, $yourAccount)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isYourAccount($user, $yourAccount);
      // Destroy the profile picture 
      if (!Storage::delete($yourAccount->profile_picture)) throw new \Exception('Error deleting profile picture.');
      // Update the profile picture and update by
      $yourAccount->update(["profile_picture" => null, "updated_by" => $yourAccount->id_user]);
      // Success
      return $this->responseJsonMessage("Foto profil berhasil dihapus.");
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }
}