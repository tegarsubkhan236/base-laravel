<?php

namespace App\Http\Middleware;

use App\Casts\UserLevel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class Gateway
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $is_must
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $is_must = null)
    {
        $userRo = Auth::user()->roles()->pluck('id');
        $userRole = $userRo[0];
        if ($is_must !== NULL || $userRole !== NULL){
            $exploded = explode("|",$is_must);
            if (in_array($userRole,$exploded)){
                $is_must = $userRole;
                //dashboard menu
                Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){
                    $e->menu->add([
                        "text"=>"Dashboard",
                        "url"=>"dashboard",
                        "icon"=>"fa fa-file"
                    ]);
                });

                if ($userRole === UserLevel::SUPER_ADMIN){
                    Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){
                        $e->menu->add(['header' => 'User Management']);
                        $e->menu->add([
                            "text"=>"User Manager",
                            "url"=>"super/user",
                            "icon"=>"fa fa-file"
                        ]);
                        $e->menu->add(['header' => 'Role Management']);
                        $e->menu->add([
                            "text"=>"Role Manager",
                            "url"=>"super/role",
                            "icon"=>"fa fa-file"
                        ]);
                        $e->menu->add(['header' => 'Role and User']);
                        $e->menu->add([
                            "text"=>"User by Role",
                            "url"=>"super/role-user",
                            "icon"=>"fa fa-file"
                        ]);
                    });
                }
                //logout menu
                Event::listen("JeroenNoten\LaravelAdminLte\Events\BuildingMenu",function ($e){
                    $e->menu->add(['header' => 'Authentication']);
                    $e->menu->add([
                        "text"=>"Logout",
                        "url"=>"logout",
                        "icon"=>"fa fa-sign-out-alt"
                    ]);
                });
            }
            if ($userRole != $is_must){
                return redirect()->route('/')->withErrors('You have no access in this page');
            }else{
                return $next($request);
            }
        }
    }
}
