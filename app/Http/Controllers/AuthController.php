<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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

            return redirect()->intended('/')->with("success", "Login success");
        }

        return back()->with("error", "Login failed");
    }

    public function logout(Request $request)
    {
    }
}