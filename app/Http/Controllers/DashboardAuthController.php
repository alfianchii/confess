<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAuthController extends Controller
{
    public function index()
    {
        return view("auth.login", ["title" => "Login"]);
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
            return redirect()->intended('/dashboard');
        }

        return redirect('/login')->with("error", 'Login gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/")->with("success", "Logout berhasil!");
    }
}