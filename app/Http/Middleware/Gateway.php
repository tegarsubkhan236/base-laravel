<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class Gateway
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()){
            Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                $event->menu->add([
                    "text" => "Dashboard",
                    "route" => "dashboard",
                    "icon" => "fa fa-home",
                ]);
                $event->menu->add([
                    "text" => "User Management",
                    "icon" => "fa fa-user",
                    "submenu" => [
                        [
                            "text" => "User",
                            "route" => "user-setting.user.index",
                            "can" => "user-list"
                        ],
                        [
                            "text" => "Role",
                            "route" => "user-setting.role.index",
                            "can" => "role-list"
                        ],
                        [
                            "text" => "Permission",
                            "route" => "user-setting.permission.index",
                            "can" => "permission-list"
                        ],
                    ]
                ]);
                $event->menu->add([
                    'header' => 'TEST CONTENT',
                    'can' => 'test-list'
                ]);
                $event->menu->add([
                    "text" => "Test",
                    "route" => "test.index",
                    "can" => "test-list",
                    "icon" => "fa fa-file",
                ]);
            });
            return $next($request);
        }else{
            return "You're not logged in";
        }
    }
}
