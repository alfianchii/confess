<?php

namespace App\Models\Traits\Helpers;

use App\Models\{User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth};

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
      $user = User::where("username", $credentials["username"])->first();
      if ($user->flag_active === "N") {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return [
          "fields" => $fields,
          "redirect" => $redirect,
          "status" => $status,
          "message" => "Akun kamu dinonaktifkan!",
        ];
      }

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
}
