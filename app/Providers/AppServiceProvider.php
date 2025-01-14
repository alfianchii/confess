<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\{DB, Schema};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
            $role = $user->userRole->role->role_name;
            return $role == "admin";
        });

        Gate::define("officer", function (User $user) {
            $role = $user->userRole->role->role_name;
            return $role == "officer";
        });

        Gate::define("student", function (User $user) {
            $role = $user->userRole->role->role_name;
            return $role === "student";
        });

        try {
            Schema::hasTable('set_website');
            $web_config = DB::table('set_website')->plucK('value', 'key');
            config(['web_config' => $web_config]);
        } catch (\Exception $e) {
        }

        Model::preventLazyLoading(!app()->environment('production'));

        if(env('APP_ENV') !== 'local')
        {
            URL::forceScheme('https');
        }
    }
}
