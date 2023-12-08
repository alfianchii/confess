<?php

namespace App\Models\Traits\Helpers;

use Illuminate\Support\Facades\{Hash};
use App\Models\{MasterRole, User};

trait Accountable
{
  // ---------------------------------
  // METHODS
  public function getRulesMessagesPassword($currentPassword = false, $newPassword = false)
  {
    $array = [
      "rules" => [
        "current_password" => ["required", "min:6"],
        "new_password" => ["required", "min:6"],
      ],
      "messages" => [
        "current_password.required" => "Password saat ini tidak boleh kosong.",
        "current_password.min" => "Password saat ini tidak boleh kurang dari :min karakter.",
        "new_password.required" => "Password baru tidak boleh kosong.",
        "new_password.min" => "Password baru tidak boleh kurang dari :min karakter."
      ],
    ];

    if ($currentPassword)
      unset($array["rules"]["new_password"], $array["messages"]["new_password.required"], $array["messages"]["new_password.min"]);
    if ($newPassword)
      unset($array["rules"]["current_password"], $array["messages"]["current_password.required"], $array["messages"]["current_password.min"]);

    return $array;
  }

  public function updateUserRules(array $rules, User $theUser, array $data)
  {
    $theUserRole = $theUser->userRole->role->role_name;
    unset($rules["password"], $rules["password_confirmation"], $rules["username"], $rules["email"]);

    if ($theUserRole === "officer") $rules['role'] = ["required"];
    if ($data["nik"] === $theUser->nik) unset($rules["nik"]);
    if (!array_key_exists("nip", $data)) unset($rules["nip"]);
    if (!array_key_exists("nisn", $data)) unset($rules["nisn"]);
    if (array_key_exists("nip", $data)) if ($data["nip"] === $theUser->officer?->nip) unset($rules["nip"]);
    if (array_key_exists("nisn", $data)) if ($data["nisn"] === $theUser->student?->nisn) unset($rules["nisn"]);

    return $rules;
  }

  public function updateUserUniqueAndRole(User $user, User $theUser, array $credentials)
  {
    $theUserRole = $theUser->userRole->role->role_name;

    if ($theUserRole === "officer") {
      $inputRole = $credentials["role"];
      $credentials["role"] = MasterRole::where("role_name", $credentials["role"])->value("id_role");

      if (array_key_exists("nip", $credentials))
        $theUser->officer()->update([
          "nip" => $credentials["nip"],
          "updated_by" => $user->id_user,
        ]);

      if ($theUserRole !== $inputRole)
        $theUser->userRole()->update(["id_role" => $credentials["role"]]);
    }

    if ($theUserRole === "student")
      if (array_key_exists("nisn", $credentials))
        $theUser->student()->update([
          "nisn" => $credentials["nisn"],
          "updated_by" => $user->id_user,
        ]);

    $credentials["updated_by"] = $user->user_id;
    $theUser->update($credentials);

    $theUser->refresh();
    return redirect("/dashboard/users")->withSuccess("Pengguna @$theUser->username berhasil di-update.");
  }

  public function alterYourPassword(User $user, $credentials, $url = "/dashboard/users/account", $message = "Password kamu berhasil diganti!")
  {
    $fields["password"] = Hash::make($credentials["new_password"]);
    $user->update($fields);
    return redirect($url)->withSuccess($message);
  }

  public function isYourAccount(User $yourAccount, User $user, string $message = "Akun tidak ditemukan.")
  {
    if ($yourAccount->id_user !== $user->id_user) throw new \Exception($message);
  }

  public function isNotYourAccount(User $yourAccount, User $user, string $message = "Ini merupakan akun kamu.")
  {
    if ($yourAccount->id_user === $user->id_user) throw new \Exception($message);
  }

  public function createRoleUser(User $theUser, array $credentials)
  {
    $theUser->userRole()->create(["id_role" => $credentials["role"]]);
    return $theUser;
  }

  public function createUniqueUser(User $theUser, string $roleName, array $credentials)
  {
    if ($roleName === "officer")
      $theUser->officer()->update([
        "nip" => $credentials["nip"],
      ]);

    if ($roleName === "student")
      $theUser->student()->update([
        "nisn" => $credentials["nisn"],
      ]);

    return $theUser;
  }

  public function checkCurrentPassword(User $user, string $currentPassword)
  {
    if (!Hash::check($currentPassword, $user->password))
      throw new \Exception("Password saat ini salah. Silakan coba lagi.");
  }

  public function checkSamePassword(string $currentPassword, string $newPassword)
  {
    if ($currentPassword === $newPassword)
      throw new \Exception("Password baru tidak boleh sama dengan password lama.");
  }
}
