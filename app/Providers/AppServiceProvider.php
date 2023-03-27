<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define("admin", function (User $user) {
            return $user->level == "admin";
        });

        Gate::define("officer", function (User $user) {
            return $user->level == "officer";
        });

        Gate::define("student", function (User $user) {
            return $user->level == "student";
        });

        Model::preventLazyLoading(!app()->environment('production'));
    }
}
