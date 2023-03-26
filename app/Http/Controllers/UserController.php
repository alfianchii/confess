<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.users.register", [
            "title" => "Register"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            "name" => ["required", "max:255"],
            "nik" => ["required", "size:16", "string", "unique:users,nik"],
            "nik" => ["numeric"],
            "username" => ["required", "unique:users,username", "min:3"],
            "email" => ["required", "unique:users,email", "email:rfc,dns"],
            "gender" => ['required'],
            "level" => ['required'],
            'password' => ['required', 'confirmed', 'min:6'],
            'password_confirmation' => ['required', 'min:6', "required_with:password", "same:password"],
            "image" => ["image", "file", "max:2048"],
        ]);

        // Encrypt password
        $credentials["password"] = Hash::make($credentials["password"]);

        // Image
        if ($request->file("image")) {
            $credentials["image"] = $request->file("image")->store('user-images');
        }

        try {
            User::create($credentials);
            return redirect('/dashboard/users')->with('success', 'Pengguna berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect('/dashboard/users')->withErrors('Pengguna gagal dibuat.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}