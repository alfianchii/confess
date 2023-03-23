<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, ComplaintController, ResponseController, DashboardController};

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

// Dashboard
Route::group(["middleware" => 'auth', "prefix" => "dashboard"], function () {
    Route::get("/", [DashboardController::class, 'index']);

    Route::get("/complaints/checkSlug", [ComplaintController::class, "checkSlug"])->middleware("student");

    // Complaint
    Route::resource("/complaints", ComplaintController::class)->middleware("student");
    // Response
    Route::resource("/responses", ResponseController::class)->middleware("response")->except("create");
    Route::get("/responses/create/{complaint:slug}", [ResponseController::class, "create"])->middleware("response");
});

// Responses data
Route::get('/dashboard/responses-data', [DashboardController::class, "responsesData"])->middleware("auth");
