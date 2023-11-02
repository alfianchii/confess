<?php

namespace App\Http\Controllers;

use App\Models\{DTOfficer, DTStudent, User, MasterRole};
use Illuminate\Support\Facades\{Auth, View};
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    // ---------------------------------
    // TRAITS
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // ---------------------------------
    // PROPERTIES
    const HOME_URL = RouteServiceProvider::HOME;
    protected User $userData;
    protected MasterRole $userRole;
    protected $userUnique;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->userData = $this->getUserData();
                $this->userRole = $this->getUserRole($this->userData);
                $this->userUnique = $this->getUserUnique($this->userData, $this->userRole);

                // Share properties to all views
                View::share('userData', $this->userData);
                View::share('userRole', $this->userRole);
                View::share('userUnique', $this->userUnique);

                // Share methods to all views
                View::share('isUserImageExist', [$this, 'isUserImageExist']);
            }

            return $next($request);
        });
    }


    // ---------------------------------
    // HELPERS
    public function getUserData()
    {
        $user = Auth::user();
        // If non-active
        if ($user->flag_active === "N") return $this->logoutUserImmediately();
        return $user;
    }

    public function getUserRole(User $user)
    {
        if (!$user->userRole) return $this->logoutUserImmediately();
        // If non-active
        if ($user->userRole->flag_active === "N") return $this->logoutUserImmediately();
        return $user->userRole->role;
    }

    public function getUserUnique(User $user, MasterRole $role)
    {
        $unique = null;
        if (!empty($role)) {
            // Admin or officer
            if ($role->role_name === "admin" || $role->role_name === "officer")
                $unique = DTOfficer::where("id_user", $user->id_user)->first();
            // Student
            if ($role->role_name === "student")
                $unique = DTStudent::where("id_user", $user->id_user)->first();
            // Check if the user's unique is not exist, then logout immediately
            if (empty($unique))
                return $this->logoutUserImmediately();
        }
        // If no role, then logout immediately
        else return $this->logoutUserImmediately();
        // If non-active
        if ($unique->flag_active === "N") return $this->logoutUserImmediately();
        // Return the unique
        return $unique;
    }

    public function logoutUserImmediately()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->intended(self::HOME_URL);
    }

    public function isUserImageExist(string $path = null)
    {
        if (!$path) return false;
        return
            File::exists(public_path('images/' . $path))
            ||
            File::exists(public_path('storage/' . $path));
    }
}
