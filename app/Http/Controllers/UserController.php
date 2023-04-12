<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage};
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all users but without the current user
        $users = User::where("id", "!=", auth()->user()->id)->orderByDesc("created_at")->get();

        return view("dashboard.users.all", [
            "title" => "Pengguna",
            "users" => $users,
        ]);
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
            "nik" => ["required", "size:16", "string"],
        ]);

        $credentials = $request->validate([
            "name" => ["required", "max:255"],
            "nik" => ["numeric", "unique:users,nik"],
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
            // Store original image
            $imageOriginalPath = $request->file('image')->store("user-images");

            // Set path 
            $credentials["image"] = $imageOriginalPath;

            // Open image using Intervention Image
            $imageCrop = Image::make("storage/" . $imageOriginalPath);

            // Crop the image to a square with a width of 300 pixels
            $imageCrop->fit(1200, 1200, function ($constraint) {
                $constraint->upsize();
            }, "top");

            // Replace original image with cropped image
            Storage::put($imageOriginalPath, $imageCrop->stream());
        }

        try {
            $user = User::create($credentials);
            return redirect("/dashboard/users/$user->username")->with('success', 'Pengguna berhasil dibuat!');
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
        return view("dashboard.users.show", [
            "title" => $user->username,
            "user" => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        return view("dashboard.users.edit", [
            "title" => "Edit " . $user->username,
            "user" => $user,
        ]);
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
        $rules = [
            "name" => ["required", "max:255"],
            "nik" => ["required", "size:16", "string"],
            "gender" => ['required'],
            "level" => ['required'],
            "image" => ["image", "file", "max:2048"],
        ];

        $credentials = $request->validate($rules);

        if ($request->username != $user->username) {
            $rules["username"] = ["required", "unique:users,username", "min:3"];
        }

        if ($request->email != $user->email) {
            $rules["email"] = ["required", "unique:users,email", "email:rfc,dns"];
        }

        if ($request->nik != $user->nik) {
            $rules["nik"] = ["numeric", "unique:users,nik"];
        }

        $credentials = $request->validate($rules);

        $username = $credentials["username"] ?? $user->username;

        if ($request->file("image")) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            // Store original image
            $imageOriginalPath = $request->file('image')->store("user-images");

            // Set path 
            $credentials["image"] = $imageOriginalPath;

            // Open image using Intervention Image
            $imageCrop = Image::make("storage/" . $imageOriginalPath);

            // Crop the image to a square with a width of 300 pixels
            $imageCrop->fit(1200, 1200, function ($constraint) {
                $constraint->upsize();
            }, "top");

            // Replace original image with cropped image
            Storage::put($imageOriginalPath, $imageCrop->stream());
        }

        try {
            // $complaint = Complaint::where("id", $complaint->id)->update($credentials);
            // Get the new and old of $complaint
            $userOld = $user->fresh();
            $user->update($credentials);
            $userNew = $user->fresh();

            // Get the old and new versions of the model as arrays
            $oldAttributes = $userOld->getAttributes();
            $newAttributes = $userNew->getAttributes();

            // Compare the arrays to see if any attributes have changed
            if ($oldAttributes === $newAttributes) {
                // The instance of the $user record has not been updated
                return redirect('/dashboard/users/' . $user->username)->with('info', 'Kamu tidak melakukan editing pada pengguna.');
            }

            // The instance of the $user record has been updated
            return redirect('/dashboard/users/' . $user->username)->with('success', "Pengguna $username berhasil di-edit!");
        } catch (\Exception $e) {
            // If something was wrong ...
            return redirect('/dashboard/users')->withErrors("Pengguna $username gagal di-edit.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $username = $user->username;

        if ($user->image) {
            Storage::delete($user->image);
        }

        try {
            if (!User::destroy($user->id)) {
                throw new \Exception('Error deleting user.');
            }
        } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
            return response()->json([
                "message" => "Gagal menghapus pengguna."
            ], 422);
        } catch (\Throwable $e) {
            // catch all exceptions here
            return response()->json([
                "message" => "An error occurred: " . $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Pengguna @$username telah dihapus!",
        ], 200);
    }

    public function promote(User $user)
    {
        try {
            $user->level = "admin";
            $user->save();
        } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
            return response()->json([
                "message" => "Gagal melakukan promote pengguna."
            ], 422);
        } catch (\Throwable $e) {
            // catch all exceptions here
            return response()->json([
                "message" => "An error occurred: " . $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Pengguna @$user->username berhasil di-promote menjadi admin!",
        ], 200);
    }

    public function demote(User $user)
    {
        try {
            $user->level = "officer";
            $user->save();
        } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
            return response()->json([
                "message" => "Gagal melakukan demote pengguna."
            ], 422);
        } catch (\Throwable $e) {
            // catch all exceptions here
            return response()->json([
                "message" => "An error occurred: " . $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Pengguna @$user->username turun pangkat menjadi officer.",
        ], 200);
    }

    public function profile()
    {
        return view("dashboard.users.profile", [
            "title" => "Profile",
            "user" => Auth::user(),
        ]);
    }

    public function setting()
    {
        return view("dashboard.users.setting", [
            "title" => "Setting",
            "user" => Auth::user(),
        ]);
    }

    public function settingUpdate(Request $request, User $user)
    {
        // Default rules for user
        $userRules = [
            "name" => ["required", "max:255"],
            "nik" => ["required", "size:16", "string"],
            "nip" => ["nullable", "size:18", "string"],
            "nisn" => ["nullable", "size:10", "string"],
            "image" => ["image", "file", "max:2048"],
        ];

        // Number rules for user (nik, nip, nisn)
        $numberRules = [
            "nik" => ["nullable", "numeric"],
            "nip" => ["nullable", "numeric"],
            "nisn" => ["nullable", "numeric"],
        ];

        $request->validate($userRules);

        // Rules for username, email, and nik
        if ($request->username != $user->username) {
            $userRules["username"] = ["required", "unique:users,username", "min:3"];
        }

        if ($request->email != $user->email) {
            $userRules["email"] = ["required", "unique:users,email", "email:rfc,dns"];
        }

        if ($request->nik != $user->nik) {
            $userRules["nik"] = ["unique:users,nik"];
        }

        // Add rules for each level
        if (isset($request->nisn)) {
            if ($request->nisn != $user->student->nisn) {
                $userRules["nisn"] = ["unique:students,nisn"];
            }
        } else if (isset($request->nip)) {
            if ($request->nip != $user->officer->nip) {
                $userRules["nip"] = ["unique:officers,nip"];
            }
        }

        // Validate all
        $request->validate($numberRules);
        $userCredentials = $request->validate($userRules);

        // Image
        if ($request->file("image")) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            // Store original image
            $imageOriginalPath = $request->file('image')->store("user-images");

            // Set path 
            $userCredentials["image"] = $imageOriginalPath;

            // Open image using Intervention Image
            $imageCrop = Image::make("storage/" . $imageOriginalPath);

            // Crop the image to a square with a width of 300 pixels
            $imageCrop->fit(1200, 1200, function ($constraint) {
                $constraint->upsize();
            }, "top");

            // Replace original image with cropped image
            Storage::put($imageOriginalPath, $imageCrop->stream());
        }

        try {
            // Update user
            $user->update($userCredentials);
            $user->refresh();

            // Update student or officer with fresh nik
            $account = $user->level == "student" ? $user->student : $user->officer;

            // Update user's level
            $account->update($userCredentials);

            // The instance of the $user record has been updated
            return redirect('/dashboard/user/profile')->with('success', "Set-up kamu berhasil disimpan!");
        } catch (\Exception $e) {
            // If something was wrong ...
            return redirect('/dashboard/user/profile')->withErrors("Set-up kamu gagal disimpan.");
        }
    }
}
