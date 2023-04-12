<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminCategoryController, AuthController, ComplaintController, ResponseController, DashboardController, PromoteController, UserController, UserSettingController};

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
Route::get("/login", [AuthController::class, "index"])->name("login")->middleware("guest");
Route::post("/login", [AuthController::class, "authenticate"])->middleware("guest");
Route::post("/logout", [AuthController::class, "logout"])->middleware("auth");

// User
Route::group(["middleware" => "auth", "prefix" => "dashboard/user"], function () {
    // User
    Route::get("/account/profile", [UserSettingController::class, "profile"]);
    Route::get("/account/setting", [UserSettingController::class, "setting"]);
    Route::put("/account/setting/{user:username}", [UserSettingController::class, "settingUpdate"]);
    Route::get("/account/password", [UserSettingController::class, "changeYourPassword"]);
    Route::put("/account/password/{user:username}", [UserSettingController::class, "changePassword"]);
    Route::get("/register", [UserController::class, "create"])->middleware("admin");
    Route::put("/{user:username}/promote", [PromoteController::class, "promote"])->middleware("admin");
    Route::put("/{user:username}/demote", [PromoteController::class, "demote"])->middleware("admin");
});

// Dashboard
Route::group(["middleware" => 'auth', "prefix" => "dashboard"], function () {
    // Dashboard
    Route::get("/", [DashboardController::class, 'index']);

    // Sluggable check
    Route::get("/complaints/checkSlug", [ComplaintController::class, "checkSlug"])->middleware("student");
    Route::get("/categories/checkSlug", [AdminCategoryController::class, "checkSlug"])->middleware("admin");

    // Complaint
    Route::resource("/complaints", ComplaintController::class)->middleware("student");
    // Response
    Route::resource("/responses", ResponseController::class)->middleware("response")->except(["create"]);
    Route::get("/responses/create/{complaint:slug}", [ResponseController::class, "create"])->middleware("response");
    // Category
    Route::resource("/categories", AdminCategoryController::class)->middleware("admin")->except(["show"]);
    // User
    Route::resource("/users", UserController::class)->middleware("admin")->except(["create"]);
});

// Responses data
Route::get('/dashboard/chart-data', [DashboardController::class, "chartData"])->middleware("auth");