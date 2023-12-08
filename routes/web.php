<?php

use App\Http\Controllers\Auth\{
    CredentialController as Credential,
};
use App\Http\Controllers\Home\{
    HomeController as Home,
    AboutController as HomeAbout,
    UserController as HomeUserController,
    ConfessionController as HomeConfession,
    ConfessionCategoryController as HomeConfessionCategory,
    ConfessionLikeController as HomeConfessionLike,
    CommentController as HomeConfessionComment,
};
use App\Http\Controllers\Dashboard\{
    DashboardController as Dashboard,
    MasterUserController as DashboardUser,
    RecConfessionController as DashboardConfession,
    MasterConfessionCategoryController as DashboardConfessionCategory,
    HistoryConfessionResponseController as DashboardConfessionResponse,
    RecConfessionCommentController as DashboardConfessionComment,
    HistoryConfessionLikeController as DashboardConfessionLike,
    SettingWebsiteController as DashboardWebsite,
};
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

// ---------------------------------
// Default Homepage Routes
Route::get('/', [Home::class, "index"]);
Route::get('/about', [HomeAbout::class, "index"]);


// ---------------------------------
// Credentials Check Routes
Route::get("/login", [Credential::class, "index"])->name("login")->middleware("guest");
Route::post("/login", [Credential::class, "authenticate"])->middleware("guest");
Route::post("/logout", [Credential::class, "logout"])->middleware("auth");


// ---------------------------------
// Authentications Routes
Route::group(["middleware" => "auth"], function () {
    // ---------------------------------
    // Homepage Routes
    Route::match(["get", "post"], "/confessions", [HomeConfession::class, "index"]);

    Route::post("/confessions/{confession:slug}/like-dislike", [HomeConfessionLike::class, "likeDislike"]);

    Route::resource("confessions.comments", HomeConfessionComment::class)->shallow()->except(["show", "index"]);
    Route::delete("/comments/{comment:id_confession_comment}/attachment", [DashboardConfessionComment::class, "destroyAttachment"]);

    Route::match(["get", "post"], '/confessions/categories', [HomeConfessionCategory::class, "index"]);

    Route::get('/users/{user:username}', [HomeUserController::class, "index"]);


    // ---------------------------------
    // Dashboard Routes
    Route::group(["prefix" => "dashboard"], function () {
        Route::get("/", [Dashboard::class, "index"]);

        Route::post('/chart-data', [Dashboard::class, "chartData"]);

        // ---------------------------------
        // Account Routes
        Route::get("/users/account", [DashboardUser::class, "profile"]);
        Route::get("/users/account/settings", [DashboardUser::class, "settings"]);
        Route::put("/users/account/settings/{user:username}", [DashboardUser::class, "settingsUpdate"]);
        Route::get("/users/account/password", [DashboardUser::class, "changePassword"]);
        Route::put("/users/account/password/update", [DashboardUser::class, "changePasswordUpdate"]);
        Route::delete("/users/account/settings/{user:username}/profile-picture", [DashboardUser::class, "destroyProfilePicture"]);
        Route::put("/users/{user:id_user}/activate", [DashboardUser::class, "activate"]);
        Route::delete("/users/account/{user:id_user}/non-active-your-account", [DashboardUser::class, "nonActiveYourAccount"]);

        // ---------------------------------
        // User Routes
        Route::get("/users/register", [DashboardUser::class, "register"]);
        Route::get("/users/history-logins", [DashboardUser::class, "historyLogins"]);
        Route::get("/users/details/{user:username}", [DashboardUser::class, "show"]);
        Route::get("/users/details/{user:username}/edit", [DashboardUser::class, "edit"]);
        Route::get("/users/details/{user:username}/role", [DashboardUser::class, "role"]);
        Route::put("/users/details/{user:username}/role/update", [DashboardUser::class, "roleUpdate"]);
        Route::patch("/users/mutate-user-password/{user:username}", [DashboardUser::class, "mutateUserPassword"]);
        Route::resource("/users", DashboardUser::class)->except(["create", "show", "edit"]);

        // ---------------------------------
        // Confession Routes
        Route::resource('confessions', DashboardConfession::class)->except(["show"]);
        Route::post("/confessions/check-slug", [DashboardConfession::class, "checkSlug"]);
        Route::put("/confessions/{confession:slug}/pick", [DashboardConfession::class, "pick"]);
        Route::put("/confessions/{confession:slug}/release", [DashboardConfession::class, "release"]);
        Route::put("/confessions/{confession:slug}/close", [DashboardConfession::class, "close"]);
        Route::delete("/confessions/{confession:slug}/image", [DashboardConfession::class, "destroyImage"]);

        // ---------------------------------
        // Confession's Category Routes
        Route::resource('/confessions/confession-categories', DashboardConfessionCategory::class)->except(["show"]);
        Route::post("/confessions/confession-categories/check-slug", [DashboardConfessionCategory::class, "checkSlug"]);
        Route::delete("/confessions/confession-categories/{confession_category}/image", [DashboardConfessionCategory::class, "destroyImage"]);
        Route::put("/confessions/confession-categories/{confession_category}/activate", [DashboardConfessionCategory::class, "activate"]);

        // ---------------------------------
        // Response Routes
        Route::resource("confessions.responses", DashboardConfessionResponse::class)->shallow()->except(["show", "index"]);
        Route::get("/confessions/responses", [DashboardConfessionResponse::class, "index"]);
        Route::delete("/responses/{response:id_confession_response}/attachment", [DashboardConfessionResponse::class, "destroyAttachment"]);

        // ---------------------------------
        // Comment Routes
        Route::resource("confessions.comments", DashboardConfessionComment::class)->shallow()->except(["show", "index"]);
        Route::get("/confessions/comments", [DashboardConfessionComment::class, "index"]);
        Route::delete("/comments/{comment:id_confession_comment}/attachment", [DashboardConfessionComment::class, "destroyAttachment"]);

        // ---------------------------------
        // Like Routes
        Route::get("/confessions/likes", [DashboardConfessionLike::class, "index"]);

        // ---------------------------------
        // Website settings
        Route::get("/website", [DashboardWebsite::class, "edit"]);
        Route::put("/website", [DashboardWebsite::class, "update"]);

        // ---------------------------------
        // EXPORTS
        Route::post('/users/export', [DashboardUser::class, "export"]);
        Route::post('/confessions/categories/export', [DashboardConfessionCategory::class, "export"]);
        Route::post('/confessions/export', [DashboardConfession::class, "export"]);
        Route::post('/confessions/responses/export', [DashboardConfessionResponse::class, "export"]);
        Route::post('/confessions/comments/export', [DashboardConfessionComment::class, "export"]);
        Route::post('/confessions/likes/export', [DashboardConfessionLike::class, "export"]);

        // ---------------------------------
        // IMPORTS
        Route::post('/users/import', [DashboardUser::class, "import"]);
        Route::post('/users/export/template', [DashboardUser::class, "exportTemplate"]);
    });
});
