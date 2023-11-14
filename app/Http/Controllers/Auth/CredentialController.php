<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistoryLogin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CredentialController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected $rules = [
        "username" => ["required"],
        "password" => ["required"],
    ];


    // ---------------------------------
    // CORES
    public function index()
    {
        return view("pages.auth.login.index", ["title" => "Masuk"]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate($this->rules);
        $baseFields = $this->baseFields($request);
        $historyLogin = $this->authAttempt($request, $credentials, $baseFields);
        HistoryLogin::create($historyLogin["fields"]);
        return redirect($historyLogin["redirect"])->with($historyLogin["status"], $historyLogin["message"]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login")->with("success", "Logout berhasil!");
    }


    // ---------------------------------
    // UTILITIES
    public function baseFields(Request $request)
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
    public function authAttempt(Request $request, array $credentials, array $fields)
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
            $redirect = self::HOME_URL;
        }

        return [
            "fields" => $fields,
            "redirect" => $redirect,
            "status" => $status,
            "message" => $message,
        ];
    }
}
