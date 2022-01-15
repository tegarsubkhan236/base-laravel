<?php

namespace App\Http\Middleware;

use App\Casts\UserLevel;
use App\Models\UserRole;
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
        $id = UserRole::select('role_id')->where(['user_id' => Auth::id()])->first();
        $check = explode("|", $is_must);

        if ($id->role_id === NULL || $is_must === NULL) {
            return back()->withErrors('Something wrong');
        }

        if (in_array($id->role_id, $check)) {
            // dashboard menu
            Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                $event->menu->add([
                    'type'         => 'navbar-search',
                    'text'         => 'search',
                    'url'          => 'yahoo/search',
                    'method'       => 'post',
                    'input_name'   => 'symbol',
                    'topnav_right' => true,
                ]);
                $event->menu->add([
                    "text" => "Dashboard",
                    "route" => "home",
                    "shift" => "ml-2",
                    "icon" => "fa fa-home",
                ]);
            });

            // Main menu
            switch ($id->role_id) {
                case UserLevel::ADMIN:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Role",
                            "icon" => "fa fa-key"
                        ]);
                        $event->menu->add(['header' => 'User Management']);
                        $event->menu->add([
                            "text" => "User",
                            "icon" => "fa fa-users"
                        ]);
                    });
                    break;
                case UserLevel::SUPER_ADMIN:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Stock",
                            "route" => "yahoo.list.sector",
                            "icon" => "fa fa-warehouse"
                        ]);
//                        $event->menu->add([
//                            "text" => "Stock Compare",
//                            "route" => "yahoo.stock.compare",
//                            "icon" => "fa fa-warehouse"
//                        ]);
                    });
                    break;
                case UserLevel::STOCK_USER:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Item",
                            "shift" => "ml-2",
                            "icon" => "fa fa-book"
                        ]);
                    });
                    break;
            }

            return $next($request);
        }

        return back()->withErrors('You have no access in this page');
    }
}
