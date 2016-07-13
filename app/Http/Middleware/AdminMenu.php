<?php

namespace App\Http\Middleware;

use Auth;
use Menu;
use Closure;
use App\Place;
use App\Category;

class AdminMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Menu::make('AdminMenu', function($menu) {

            if (!Auth::check()) {
                return;
            }

            /*if (Auth::user()->currentTeam) {
                $menu->add('<i class="fa fa-dashboard"></i><span class="nav-label">Dashboard</span>', [ 'route' => 'dashboard' ]);

                $booking = $menu->add('<i class="fa fa-calendar"></i><span class="nav-label">Booking</span>', '#');
                $booking->add('Bookings', [ 'route' => 'bookings.index' ]);

                //$menu->divide();
            }*/

            $menu->add('<i class="fa fa-dashboard"></i><span>Dashboard</span>', ['route' => 'home']);

            $menu->raw('PLACES', ['class' => 'header']);
            $menu->add('<i class="fa fa-plus"></i><span>Create place</span>', ['route' => 'places.create']);

            foreach (Place::all() as $index => $place) {
                $menu->add('<i class="fa fa-globe"></i><span>' . $place->name . '</span>', ['route' => ['places.show', $place->id]]);

                if ($index == 4) {
                    $menu->add('<i class="fa fa-circle-o text-aqua"></i><span>View all</span>', ['route' => 'places.index']);
                    break;
                }
            }

            $menu->raw('CATEGORIES', ['class' => 'header']);
            $menu->add('<i class="fa fa-plus"></i><span>Create category</span>', ['route' => 'categories.create']);
            $menu->add('<i class="fa fa-circle-o text-yellow"></i><span>View all</span>', ['route' => 'categories.index']);

            // $menu->raw('FLOORS', ['class' => 'header']);
            // $menu->add('<i class="fa fa-plus"></i><span>Create floor</span>', ['route' => 'maps.create']);
            // $menu->add('<i class="fa fa-circle-o text-red"></i><span>View all</span>', ['route' => 'maps.index']);
            //
            // $menu->raw('LOCATIONS', ['class' => 'header']);
            // $menu->add('<i class="fa fa-plus"></i><span>Create location</span>', ['route' => 'locations.create']);
            // $menu->add('<i class="fa fa-circle-o text-green"></i><span>View all</span>', ['route' => 'locations.index']);

            $menu->raw('BEACONS', ['class' => 'header']);
            $menu->add('<i class="fa fa-plus"></i><span>Create beacon</span>', ['route' => 'beacons.create']);
            $menu->add('<i class="fa fa-circle-o text-blue"></i><span>View all</span>', ['route' => 'beacons.index']);

            $menu->raw('SYSTEM', ['class' => 'header']);

            if(Auth::user()->teams()->count() <> 1) {
                $menu->add('<i class="fa fa-users"></i><span>Teams</span>', ['route' => 'teams.index']);
            }

            if(Auth::user()->isOwnerOfCurrentTeam()) {
                $menu->add('<i class="fa fa-users"></i><span>Users</span>', ['route' => 'teams.members.show']);
            }

        });

        return $next($request);
    }
}
