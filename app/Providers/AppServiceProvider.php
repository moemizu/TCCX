<?php

namespace App\Providers;

use App\Permission;
use App\TCCX\ScoreData;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('permissions'))
            foreach (Permission::all() as $permission) {
                Gate::define($permission->name, function (User $user) use ($permission) {
                    return $user->permissions()->where('name', $permission->name)->exists();
                });
            }
        // Score data
        $this->app->singleton('TCCX\ScoreData', function () {
            return new ScoreData();
        });
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
