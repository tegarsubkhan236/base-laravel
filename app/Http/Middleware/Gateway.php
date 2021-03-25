<?php

namespace App\Http\Middleware;

use App\Casts\UserLevel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class Gateway
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $is_must
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $is_must = null)
    {
        $roleId = Auth::user()->roles()->pluck('id');
        $userRole = $roleId[0];
        if ($is_must !== NULL || $userRole !== NULL){
            $exploded = explode("|",$is_must);
            if (in_array($userRole,$exploded)){
                $is_must = $userRole;
                //dashboard menu
                Event::listen(BuildingMenu::class,function (BuildingMenu $event){
                    $event->menu->add([
                        'header' => 'Master Data',]);
                    $event->menu->add([
                        "text"=>"Dashboard",
                        "route"=>"dashboard",
                        "shift" => "ml-2",
                        "icon"=>"fa fa-home",
                    ]);
                });

                switch ($userRole) {
                    case UserLevel::SUPER_ADMIN:
                        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                            $event->menu->add([
                                'key'=>'user',
                                "text" => "User",
                                "route" => "super.user",
                                "shift" => "ml-2",
                                "icon" => "fa fa-users"
                            ]);
//                            $event->menu->addIn('user',[
//                                'key'=>'user',
//                                "text" => "User Manager",
//                                "route" => "super.user",
//                                "icon" => "fa fa-file"
//                            ]);
                            $event->menu->add([
                                "text" => "Role",
                                "route" => "super.role",
                                "shift" => "ml-2",
                                "icon" => "fa fa-key"
                            ]);
//                            $event->menu->add(['header' => 'ROLE AND USER']);
                            $event->menu->add([
                                "text" => "User by Role",
                                "route" => "super.role-user",
                                "shift" => "ml-2",
                                "icon" => "fa fa-database"
                            ]);
                        });
                        break;
                    case UserLevel::ADMIN:
                        echo "hallo word";
                        break;
                    case UserLevel::USER:
                        echo "hallo world";
                        break;
                }

                //logout menu
                Event::listen(BuildingMenu::class,function (BuildingMenu $event){
                    $event->menu->add([
                        'header' => 'Authentication',
                    ]);
                    $event->menu->add([
                        "text"=>"Profile",
                        "route" => ["profile",['user_id' => Auth::id()]],
                        "shift" => "ml-2",
                        "icon"=>"fa fa-user-alt"
                    ]);
                    $event->menu->add([
                        "url" => "logout",
                        'method' => "POST",
                        "text"=>"Logout",
                        "shift" => "ml-2",
                        "icon"=>"fa fa-sign-out-alt"
                    ]);
                });
            }
            if ($userRole != $is_must){
                return redirect()->route('/')->withErrors('You have no access in this page');
            }
            return $next($request);
        }
        return redirect()->route('/')->withErrors('You have no access in this page');
    }
}
