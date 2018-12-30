<?php

namespace App\Providers;

use App\Permission;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // appends all query string to paginator
        $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
            return $paginator->appends(array_except(Input::query(), $paginator->getPageName()));
        });
        // Register permission
        foreach (Permission::all() as $permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->permissions()->where('name', $permission->name)->exists();
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
