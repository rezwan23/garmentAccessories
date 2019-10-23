<?php

namespace App\Providers;

use App\Models\Permission;
use App\User;
use Illuminate\Support\Facades\Gate;
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
        Schema::defaultStringLength(191);
        if(!$this->app->runningInConsole()){

            Permission::all()->each(function ($permission){
                Gate::define($permission->permission, function (User $user)use($permission){
                    $user = auth()->user();
                    /** @var User $user */
                    if($user->isSuperAdmin()){
                        return true;
                    }
                    foreach ($user->role->permissions as $p){
                        if($p->permission == $permission->permission){
                            return true;
                        }
                    }
                    return false;
                });
            });
        }
    }
}
