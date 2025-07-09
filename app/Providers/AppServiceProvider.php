<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('add-person-to-medal-profile', function ($user) {
            return $user->can('create_addmedal');
        });
        Gate::define('bulk-add-person-to-medal-profile', function ($user) {
             return $user->can('create_addmedal_bulk');
        });
        Gate::define('add-person-to-clasp-profile', function ($user) {
            return $user->can('create_addclasp');
        });
        Gate::define('user-management', function ($user) {
            return $user->can('user_management');
        });
        Gate::define('master-data', function ($user) {
            return $user->can('master_data');
        });
        Gate::define('user-menu', function ($user) {
            return $user->can('users');
        });
        Gate::define('permissions-menu', function ($user) {
            return $user->can('permissions');
        });
        Gate::define('roles-menu', function ($user) {
            return $user->can('roles');
        });


    }
}
