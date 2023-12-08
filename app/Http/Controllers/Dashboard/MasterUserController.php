<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\UserService;
use App\Http\Controllers\Controller;
use App\Models\{User};
use Illuminate\Http\Request;

class MasterUserController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected UserService $userService;


    // ---------------------------------
    // MAGIC FUNCTIONS 
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->userService->index($this->userData, $this->userRole);
    }

    public function register()
    {
        return $this->userService->register($this->userRole);
    }

    public function store(Request $request)
    {
        return $this->userService->store($request, $this->userData, $this->userRole);
    }

    public function show(User $user)
    {
        return $this->userService->show($this->userData, $this->userRole, $user);
    }

    public function edit(User $user)
    {
        return $this->userService->edit($this->userRole, $user);
    }

    public function update(Request $request, User $user)
    {
        return $this->userService->update($request, $this->userData, $this->userRole, $user);
    }

    public function destroy($idUser)
    {
        return $this->userService->destroy($this->userData, $this->userRole, $idUser);
    }

    public function export(Request $request)
    {
        return $this->userService->export($request, $this->userRole);
    }

    public function exportTemplate(Request $request)
    {
        return $this->userService->exportTemplate($request, $this->userRole);
    }

    public function import(Request $request)
    {
        return $this->userService->import($request, $this->userRole);
    }


    // ---------------------------------
    // UTILITIES
    public function profile()
    {
        return $this->userService->profile($this->userRole);
    }

    public function settings()
    {
        return $this->userService->settings($this->userRole);
    }

    public function settingsUpdate(Request $request, User $user)
    {
        return $this->userService->settingsUpdate($request, $this->userData, $this->userRole, $this->userUnique, $user);
    }

    public function changePassword()
    {
        return $this->userService->changePassword($this->userRole);
    }

    public function changePasswordUpdate(Request $request)
    {
        return $this->userService->changePasswordUpdate($request, $this->userData, $this->userRole);
    }

    public function destroyProfilePicture($idUser)
    {
        return $this->userService->destroyProfilePicture($this->userData, $this->userRole, $idUser);
    }

    public function activate($idUser)
    {
        return $this->userService->activate($this->userData, $this->userRole, $idUser);
    }

    public function nonActiveYourAccount($idUser)
    {
        return $this->userService->nonActiveYourAccount($this->userRole, $idUser);
    }

    public function historyLogins()
    {
        return $this->userService->historyLogins($this->userRole);
    }

    public function role(User $user)
    {
        return $this->userService->role($this->userData, $this->userRole, $user);
    }

    public function roleUpdate(Request $request, User $user)
    {
        return $this->userService->roleUpdate($request, $this->userData, $this->userRole, $user);
    }

    public function mutateUserPassword(Request $request, User $user)
    {
        return $this->userService->mutateUserPassword($request, $this->userRole, $user);
    }
}
