<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        Paginator::useBootstrapFive();

        Gate::define("admin", function (User $user) {
            return $user->level == "admin";
        });

        Gate::define("officer", function (User $user) {
            return $user->level == "officer";
        });

        Gate::define("student", function (User $user) {
            return $user->level == "student";
        });

        try {
            Schema::hasTable('settings');
            $web_config = DB::table('settings')->pluck('value', 'key');
            config(['web_config' => $web_config]);
        } catch (\Exception $e) {
        }

        Model::preventLazyLoading(!app()->environment('production'));
    }
}
