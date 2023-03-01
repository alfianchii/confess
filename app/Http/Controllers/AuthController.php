<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view("auth.login", ["title" => "Login"]);
    }

    public function authenticate(Request $request)
    {
    }

    public function logout(Request $request)
    {
    }
}
