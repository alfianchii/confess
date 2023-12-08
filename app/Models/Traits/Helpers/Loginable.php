<?php

namespace App\Models\Traits\Helpers;

use Illuminate\Support\Facades\{Auth};
use Illuminate\Http\Request;
use App\Models\{User};

trait Loginable
{
  // ---------------------------------
  // METHODS
  public function loginFields(Request $request)
  {
    $serverInformations = $request->server();
    return [
      "username" => $request->username,
      "operating_system" => $serverInformations["HTTP_SEC_CH_UA_PLATFORM"] ?? "Unknown",
      "remote_address" => $request->ip(),
      "user_agent" => $request->userAgent(),
      "browser" => $serverInformations["HTTP_SEC_CH_UA"] ?? "Unknown",
      "attempt_result" => "N",
    ];
  }

  public function authAttempt(Request $request, array $credentials, array $fields, string $url)
  {
    $redirect = "/login";
    $status = "error";
    $message = "Username atau password salah!";
    $attempted = Auth::attempt([
      "username" => $credentials["username"],
      "password" => $credentials['password'],
    ]);

    if ($attempted) {
      $user = User::firstWhere("username", $credentials["username"]);
      if ($user->flag_active === "N")
        return $this->loginFailed($fields, $redirect, $status);

      $user->update(["last_login_at" => now()]);
      $fields["attempt_result"] = "Y";
      $request->session()->regenerate();
      session(['issued_time' => time()]);
      $status = "success";
      $message = "Login berhasil!";
      $redirect = $url;
    }

    return [
      "fields" => $fields,
      "redirect" => $redirect,
      "status" => $status,
      "message" => $message,
    ];
  }

  public function loginFailed($fields, $url, $status)
  {
    $this->breakUserSession();

    return [
      "fields" => $fields,
      "redirect" => $url,
      "status" => $status,
      "message" => "Akun kamu dinonaktifkan!",
    ];
  }

  public function breakUserSession()
  {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
  }
}
