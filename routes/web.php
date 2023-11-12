<?php

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

// Default Homepage Routes
Route::get('/', "\App\Http\Controllers\Home\HomeController@index");
Route::get('/about', "\App\Http\Controllers\Home\AboutController@index");


// ---------------------------------
// Credentials Check Routes
Route::get("/login", "\App\Http\Controllers\Auth\CredentialController@index")->name("login")->middleware("guest");
Route::post("/login", "\App\Http\Controllers\Auth\CredentialController@authenticate")->middleware("guest");
Route::post("/logout", "\App\Http\Controllers\Auth\CredentialController@logout")->middleware("auth");


// ---------------------------------
// Authentications Routes
Route::group(["middleware" => "auth"], function () {
    // ---------------------------------
    // Homepage Routes
    // Route: /
    // ---------------------------------
    // Confession Routes
    Route::match(["get", "post"], "/confessions", "\App\Http\Controllers\Home\ConfessionController@index");

    // ---------------------------------
    // Comment Routes
    Route::resource("confessions.comments", "\App\Http\Controllers\Home\CommentController")->shallow()->except(["show", "index"]);
    // Destroy (attachment)
    Route::delete("/comments/{comment:id_confession_comment}/attachment", "\App\Http\Controllers\Home\CommentController@destroyAttachment");


    // ---------------------------------
    // Dashboard Routes
    // Route: /dashboard/
    Route::group(["prefix" => "dashboard"], function () {
        // Base Route
        Route::get("/", "\App\Http\Controllers\Dashboard\DashboardController@index");

        // ---------------------------------
        // Chart Routes
        Route::post('/chart-data', "\App\Http\Controllers\Dashboard\DashboardController@chartData");

        // ---------------------------------
        // Account Routes
        // Profile
        Route::get("/users/account", "\App\Http\Controllers\Dashboard\MasterUserController@profile");
        // Settings
        Route::get("/users/account/settings", "\App\Http\Controllers\Dashboard\MasterUserController@settings");
        Route::put("/users/account/settings/{user:username}", "\App\Http\Controllers\Dashboard\MasterUserController@settingsUpdate");
        // Change password
        Route::get("/users/account/password", "\App\Http\Controllers\Dashboard\MasterUserController@changePassword");
        Route::put("/users/account/password/update", "\App\Http\Controllers\Dashboard\MasterUserController@changePasswordUpdate");
        // Destroy (profile picture)
        Route::delete("/users/account/settings/{user:username}/profile-picture", "\App\Http\Controllers\Dashboard\MasterUserController@destroyProfilePicture");
        // Activate
        Route::put("/users/{user:id_user}/activate", "\App\Http\Controllers\Dashboard\MasterUserController@activate");
        // Non-active your account
        Route::delete("/users/account/{user:id_user}/non-active-your-account", "\App\Http\Controllers\Dashboard\MasterUserController@nonActiveYourAccount");

        // ---------------------------------
        // User Routes
        // Register
        Route::get("/users/register", "\App\Http\Controllers\Dashboard\MasterUserController@register");
        // History logins
        Route::get("/users/history-logins", "\App\Http\Controllers\Dashboard\MasterUserController@historyLogins");
        // User's details
        Route::get("/users/details/{user:username}", "\App\Http\Controllers\Dashboard\MasterUserController@show");
        // User's details of edit
        Route::get("/users/details/{user:username}/edit", "\App\Http\Controllers\Dashboard\MasterUserController@edit");
        // User's change role
        Route::get("/users/details/{user:username}/role", "\App\Http\Controllers\Dashboard\MasterUserController@role");
        Route::put("/users/details/{user:username}/role/update", "\App\Http\Controllers\Dashboard\MasterUserController@roleUpdate");
        // Change password
        Route::patch("/users/mutate-user-password/{user:username}", "\App\Http\Controllers\Dashboard\MasterUserController@mutateUserPassword");
        // User
        Route::resource("/users", "\App\Http\Controllers\Dashboard\MasterUserController")->except(["create", "show", "edit"]);

        // ---------------------------------
        // Confession Routes
        Route::resource('confessions', "\App\Http\Controllers\Dashboard\RecConfessionController")->except(["show"]);
        // Sluggable check
        Route::post("/confessions/check-slug", "\App\Http\Controllers\Dashboard\RecConfessionController@checkSlug");
        // Pick
        Route::put("/confessions/{confession:slug}/pick", "\App\Http\Controllers\Dashboard\RecConfessionController@pick");
        // Release
        Route::put("/confessions/{confession:slug}/release", "\App\Http\Controllers\Dashboard\RecConfessionController@release");
        // Close
        Route::put("/confessions/{confession:slug}/close", "\App\Http\Controllers\Dashboard\RecConfessionController@close");
        // Destroy image
        Route::delete("/confessions/{confession:slug}/image", "\App\Http\Controllers\Dashboard\RecConfessionController@destroyImage");

        // ---------------------------------
        // Confession's Category Routes
        Route::resource('/confessions/confession-categories', "\App\Http\Controllers\Dashboard\MasterConfessionCategoryController")->except(["show"]);
        // Sluggable check
        Route::post("/confessions/confession-categories/check-slug", "\App\Http\Controllers\Dashboard\MasterConfessionCategoryController@checkSlug");
        // Destroy image
        Route::delete("/confessions/confession-categories/{confession_category}/image", "\App\Http\Controllers\Dashboard\MasterConfessionCategoryController@destroyImage");
        // Activate
        Route::put("/confessions/confession-categories/{confession_category}/activate", "\App\Http\Controllers\Dashboard\MasterConfessionCategoryController@activate");

        // ---------------------------------
        // Response Routes
        Route::resource("confessions.responses", "\App\Http\Controllers\Dashboard\HistoryConfessionResponseController")->shallow()->except(["show", "index"]);
        // Index
        Route::get("/confessions/responses", "\App\Http\Controllers\Dashboard\HistoryConfessionResponseController@index");
        // Destroy (attachment)
        Route::delete("/responses/{response:id_confession_response}/attachment", "\App\Http\Controllers\Dashboard\HistoryConfessionResponseController@destroyAttachment");

        // ---------------------------------
        // Comment Routes
        Route::get("/comments", "\App\Http\Controllers\Dashboard\RecConfessionCommentController@index");

        // ---------------------------------
        // Website settings
        Route::get("/website", "\App\Http\Controllers\Dashboard\SettingWebsiteController@edit");
        Route::put("/website", "\App\Http\Controllers\Dashboard\SettingWebsiteController@update");

        // ---------------------------------
        // EXPORTS
        // Users
        Route::post('/users/export', "\App\Http\Controllers\Dashboard\MasterUserController@export");
        // Confession's categories
        Route::post('/confessions/categories/export', "\App\Http\Controllers\Dashboard\MasterConfessionCategoryController@export");
        // Confessions
        Route::post('/confessions/export', "\App\Http\Controllers\Dashboard\RecConfessionController@export");
        // Confession's responses
        Route::post('/confessions/responses/export', "\App\Http\Controllers\Dashboard\HistoryConfessionResponseController@export");

        // ---------------------------------
        // IMPORTS
        // User
        Route::post('/users/import', "\App\Http\Controllers\Dashboard\MasterUserController@import");
        // Template
        Route::post('/users/export/template', "\App\Http\Controllers\Dashboard\MasterUserController@exportTemplate");
    });
});
