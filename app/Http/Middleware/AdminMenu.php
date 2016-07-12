<?php

namespace App\Http\Middleware;

use Auth;
use Menu;
use Closure;

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

            $menu->raw('MENU', ['class' => 'header']);
            $menu->add('<i class="fa fa-home"></i> Home', ['route' => 'home']);

            if(Auth::user()->teams()->count() <> 1) {
                $menu->add('<i class="fa fa-users"></i> Teams', ['route' => 'teams.index']);
            }

            if(Auth::user()->isOwnerOfCurrentTeam()) {
                $menu->add('<i class="fa fa-users"></i> Users', ['route' => 'teams.members.show']);
            }

        });

        return $next($request);
    }
}
