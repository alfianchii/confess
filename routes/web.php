<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboards\{DashboardAdminCategoryController, DashboardAuthController, DashboardComplaintController, DashboardResponseController, DashboardController, DashboardUserPromoteController, DashboardUserController, DashboardUserSettingController};
use App\Http\Controllers\{ComplaintController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Homepage
Route::get('/', function () {
    return view('home', ["title" => "Welcome!"]);
});

Route::get('/about', function () {
    return view('about', ["title" => "Tentang"]);
});

// Authentication
Route::get("/login", [DashboardAuthController::class, "index"])->name("login")->middleware("guest");
Route::post("/login", [DashboardAuthController::class, "authenticate"])->middleware("guest");
Route::post("/logout", [DashboardAuthController::class, "logout"])->middleware("auth");

// User
Route::group(["middleware" => "auth", "prefix" => "dashboard/user"], function () {
    // User
    Route::get("/account/profile", [DashboardUserSettingController::class, "profile"]);
    Route::get("/account/setting", [DashboardUserSettingController::class, "setting"]);
    Route::put("/account/setting/{user:username}", [DashboardUserSettingController::class, "settingUpdate"]);
    Route::get("/account/password", [DashboardUserSettingController::class, "changeYourPassword"]);
    Route::put("/account/password/{user:username}", [DashboardUserSettingController::class, "changePassword"]);
    Route::get("/register", [DashboardUserController::class, "create"])->middleware("admin");
    Route::put("/{user:username}/promote", [DashboardUserPromoteController::class, "promote"])->middleware("admin");
    Route::put("/{user:username}/demote", [DashboardUserPromoteController::class, "demote"])->middleware("admin");
});

/* Landing page */
Route::resource('/complaints', ComplaintController::class)->except(["create", "edit", "update", "destroy", "store"])->middleware("auth");

// Dashboard
Route::group(["middleware" => 'auth', "prefix" => "dashboard"], function () {
    // Dashboard
    Route::get("/", [DashboardController::class, 'index']);

    // Sluggable check
    Route::get("/complaints/checkSlug", [DashboardComplaintController::class, "checkSlug"])->middleware("student");
    Route::get("/categories/checkSlug", [DashboardAdminCategoryController::class, "checkSlug"])->middleware("admin");

    // Complaint
    Route::resource("/complaints", DashboardComplaintController::class)->middleware("student");
    // Response
    Route::resource("/responses", DashboardResponseController::class)->middleware("response")->except(["create"]);
    Route::get("/responses/create/{complaint:slug}", [DashboardResponseController::class, "create"])->middleware("response");
    // Category
    Route::resource("/categories", DashboardAdminCategoryController::class)->middleware("admin")->except(["show"]);
    // User
    Route::resource("/users", DashboardUserController::class)->middleware("admin")->except(["create"]);
});

// Responses data
Route::get('/dashboard/chart-data', [DashboardController::class, "chartData"])->middleware("auth");
