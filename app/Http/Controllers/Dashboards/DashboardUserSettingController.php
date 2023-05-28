<?php

namespace App\Http\Controllers\Dashboards;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\{Auth, Hash, Storage};

class DashboardUserSettingController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $previousUrl = $request->headers->get('referer');

        return view("dashboard.users.profile", [
            "title" => "Profil",
            "user" => Auth::user(),
            "previousUrl" => $previousUrl
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setting(Request $request)
    {
        $previousUrl = $request->headers->get('referer');

        return view("dashboard.users.setting", [
            "title" => "Pengaturan",
            "user" => Auth::user(),
            "previousUrl" => $previousUrl
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
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
            return redirect('/dashboard/user/account/profile')->with('success', "Set-up kamu berhasil disimpan!");
        } catch (\Exception $e) {
            // If something was wrong ...
            return redirect('/dashboard/user/account/profile')->withErrors("Set-up kamu gagal disimpan.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeYourPassword(Request $request)
    {
        $previousUrl = $request->headers->get('referer');

        return view("dashboard.users.password", [
            "title" => "Ganti Password",
            "user" => Auth::user(),
            "previousUrl" => $previousUrl,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, User $user)
    {
        $credentials = $request->validate([
            "current_password" => ["required", "min:6"],
            "new_password" => ["required", "min:6"],
        ]);

        // Password validation
        if (Hash::check($credentials["current_password"], $user->password)) {
            $data["password"] = Hash::make($credentials["new_password"]);

            $user->update($data);
        } else {
            return redirect("/dashboard/user/account/password")->with("errorPassword", "Password lama salah! Silakan coba lagi.");
        }

        // The instance of the $user record has been updated
        return redirect('/dashboard/user/account/profile')->with('success', "Set-up kamu berhasil disimpan!");
    }
}
