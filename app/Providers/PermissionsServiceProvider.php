<?php
namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class PermissionsServiceProvider extends AuthServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->registerPolicies();

        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }

        //Blade directives
        Blade::if('role', function ($role) {
            return auth()->user()->hasRole($role);
        });
        return false;
    }
}

