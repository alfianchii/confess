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
    const DASHBOARD_URL = RouteServiceProvider::DASHBOARD;
    protected User $userData;
    protected MasterRole $userRole;
    protected $userUnique;


    // MAGIC FUNCTIONS
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->userData = $this->getUserData();
                $this->userRole = $this->getUserRole($this->userData);
                $this->userUnique = $this->getUserUnique($this->userData, $this->userRole);

                View::share('userData', $this->userData);
                View::share('userRole', $this->userRole);
                View::share('userUnique', $this->userUnique);

                View::share('isUserImageExist', [$this, 'isUserImageExist']);
            }

            return $next($request);
        });
    }


    // ---------------------------------
    // UTILITIES
    public function getUserData()
    {
        $user = Auth::user();
        if ($user->flag_active === "N") return $this->logoutUserImmediately();

        return $user;
    }

    public function getUserRole(User $user)
    {
        if (!$user->userRole) return $this->logoutUserImmediately();
        if ($user->userRole->flag_active === "N") return $this->logoutUserImmediately();

        return $user->userRole->role;
    }

    public function getUserUnique(User $user, MasterRole $role)
    {
        $unique = null;
        if (!empty($role)) {
            if ($role->role_name === "admin" || $role->role_name === "officer")
                $unique = DTOfficer::firstWhere("id_user", $user->id_user);
            if ($role->role_name === "student")
                $unique = DTStudent::firstWhere("id_user", $user->id_user);
            if (empty($unique))
                return $this->logoutUserImmediately();
        } else return $this->logoutUserImmediately();
        if ($unique->flag_active === "N") return $this->logoutUserImmediately();

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
