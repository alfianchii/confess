<?php

namespace App\Http\Controllers\Dashboards;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class DashboardAuthController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function index()
    {
        return view("auth.login", ["title" => "Masuk"]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "username" => ["required"],
            "password" => ["required"],
        ]);

        if (Auth::attempt(["username" => $credentials["username"], "password" => $credentials['password']])) {
            $request->session()->regenerate();

            // return redirect()->intended('/dashboard')->with("success", "Login berhasil!");
            return redirect()->intended($this->redirectTo)->with("success", "Login berhasil!");
        }

        return redirect('/login')->with("error", 'Login gagal :(');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/")->with("success", "Logout berhasil!");
    }
}
