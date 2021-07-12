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
        $roleId = Auth::user()->roles()->pluck('id')[0];
        $check = explode("|", $is_must);

        if ($roleId === NULL || $is_must === NULL) {
            return back()->withErrors('Something wrong');
        }

        if (in_array($roleId, $check)) {
            // dashboard menu
            Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                $event->menu->add([
                    "text" => "Dashboard",
                    "route" => "dashboard",
                    "shift" => "ml-2",
                    "icon" => "fa fa-home",
                ]);
            });

            // Main menu
            switch ($roleId) {
                case UserLevel::SUPER_ADMIN:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Role",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                        $event->menu->add(['header' => 'User Management']);
                        $event->menu->add([
                            'key' => 'user',
                            "text" => "User",
                            "route" => "super.user.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-users"
                        ]);
                    });
                    break;
                case UserLevel::ADMIN:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Stock",
                            "route" => "stock.master.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-warehouse"
                        ]);
                        $event->menu->add(['header' => 'Transaction',]);
                        $event->menu->add([
                            "text" => "Sell Transaction",
                            "route" => "sell.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-chart-line"
                        ]);
                        $event->menu->add(['header' => 'Report',]);
                        $event->menu->add([
                            "text" => "Sell Report",
                            "route" => "sell.report.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                    });
                    break;
                case UserLevel::WAREHOUSE:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Item Category",
                            "route" => "item.category.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-book"
                        ]);
                        $event->menu->add([
                            "text" => "Item",
                            "route" => "item.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-book"
                        ]);
                        $event->menu->add(['header' => 'Stock',]);
                        $event->menu->add([
                            "text" => "Stock",
                            "route" => "stock.master.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-warehouse"
                        ]);
                        $event->menu->add([
                            "text" => "Supplier Stock",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-warehouse"
                        ]);
                        $event->menu->add(['header' => 'Transaction',]);
                        $event->menu->add([
                            "text" => "Buy Transaction",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                        $event->menu->add(['header' => 'Report']);
                        $event->menu->add([
                            "text" => "Buy Report",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                    });
                    break;
                case UserLevel::SUPPLIER:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Item",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                        $event->menu->add(['header' => 'Stock',]);
                        $event->menu->add([
                            "text" => "Stock",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-warehouse"
                        ]);
                        $event->menu->add(['header' => 'Transaction',]);
                        $event->menu->add([
                            "text" => "Sell Transaction",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                    });
                    break;
                case UserLevel::OWNER:
                    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                        $event->menu->add(['header' => 'Master Data',]);
                        $event->menu->add([
                            "text" => "Supplier",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-user"
                        ]);
                        $event->menu->add([
                            "text" => "Item Category",
                            "route" => "item.category.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-book"
                        ]);
                        $event->menu->add([
                            "text" => "Item",
                            "route" => "item.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-book"
                        ]);
                        $event->menu->add(['header' => 'Stock',]);
                        $event->menu->add([
                            "text" => "Stock",
                            "route" => "stock.master.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-warehouse"
                        ]);
                        $event->menu->add([
                            "text" => "Supplier Stock",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-warehouse"
                        ]);
                        $event->menu->add(['header' => 'Report',]);
                        $event->menu->add([
                            "text" => "Buy Report",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                        $event->menu->add([
                            "text" => "Sell Report",
                            "route" => "super.role.index",
                            "shift" => "ml-2",
                            "icon" => "fa fa-key"
                        ]);
                    });
                    break;
            }

            // Authentication
            Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                $event->menu->add([
                    'header' => 'Authentication',
                ]);
                $event->menu->add([
                    "text" => "Profile",
                    "route" => ["profile", ['user_id' => Auth::id()]],
                    "shift" => "ml-2",
                    "icon" => "fa fa-user-alt"
                ]);
                $event->menu->add([
                    "url" => "logout",
                    'method' => "GET",
                    "text" => "Logout",
                    "shift" => "ml-2",
                    "icon" => "fa fa-sign-out-alt",
                    "data" => [
                        'id' => Auth::id()
                    ]
                ]);
            });
            return $next($request);
        }

        return back()->withErrors('You have no access in this page');
    }
}
