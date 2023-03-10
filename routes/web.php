<?php

use App\Http\Controllers\{AuthController, ComplaintController, DashboardController};
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home', ["title" => "Welcome!"]);
});

Route::get('/about', function () {
    return view('about', ["title" => "Tentang"]);
});

Route::get("/login", [AuthController::class, "index"])->name("login")->middleware("guest");
Route::post("/login", [AuthController::class, "authenticate"])->middleware("guest");
Route::post("/logout", [AuthController::class, "logout"])->middleware("auth");

Route::group(["middleware" => 'auth', "prefix" => "dashboard"], function () {
    Route::get("/", [DashboardController::class, 'index']);

    Route::get("/complaints/checkSlug", [ComplaintController::class, "checkSlug"]);

    Route::resource("/complaints", ComplaintController::class)->middleware("student");
});