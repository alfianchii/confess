<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{HistoryLogin};
use Illuminate\Support\Facades\{Auth};
use App\Models\Traits\Helpers\{Loginable};

class CredentialController extends Controller
{
    // ---------------------------------
    // TRAITS
    use Loginable;


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
        $baseFields = $this->loginFields($request);
        $historyLogin = $this->authAttempt($request, $credentials, $baseFields, self::DASHBOARD_URL);
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
}
