<?php

namespace App\Http\Middleware;

use Auth;
use Menu;
use Closure;
use App\Place;
use App\Poi;

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

            $menu->add('<i class="fa fa-dashboard"></i><span>Dashboard</span>', ['route' => 'home']);

            $menu->raw('PLACES', ['class' => 'header']);
            foreach (Place::all() as $index => $place) {
                $menu->add('<i class="fa fa-globe"></i><span>' . $place->name . '</span>', ['route' => ['places.show', $place->id]]);

                if ($index == 4) {
                    $menu->add('<i class="fa fa-circle-o text-aqua"></i><span>All Places</span>', ['route' => 'places.index']);
                    break;
                }
            }
            $menu->add('<i class="fa fa-plus"></i><span>Add New</span>', ['route' => 'places.create']);

            $menu->raw('POINT OF INTERESTS', ['class' => 'header']);
            $menu->add('<i class="fa fa-map-marker"></i><span>All POIs</span>', ['route' => 'pois.index']);
            $menu->add('<i class="fa fa-plus"></i><span>Add New</span>', ['route' => 'pois.create']);

            $menu->raw('BUILDING BLOCKS', ['class' => 'header']);
            $menu->add('<i class="fa fa-square"></i><span>All Blocks</span>', ['route' => 'blocks.index']);
            $menu->add('<i class="fa fa-plus"></i><span>Add New</span>', ['route' => 'blocks.create']);

            $menu->raw('BEACONS', ['class' => 'header']);
            $menu->add('<i class="fa fa-bullseye"></i><span>All Beacons</span>', ['route' => 'beacons.index']);
            $menu->add('<i class="fa fa-plus"></i><span>Add New</span>', ['route' => 'beacons.create']);
            $menu->add('<i class="fa fa-cloud-download"></i><span>Import Beacons</span>', ['route' => 'beacons.import']);

            $menu->raw('SETTINGS', ['class' => 'header']);

            if(Auth::user()->teams()->count() <> 1) {
                $menu->add('<i class="fa fa-users"></i><span>Teams</span>', ['route' => 'teams.index']);
            }

                $menu->add('<i class="fa fa-users"></i><span>Users</span>', ['route' => 'teams.members.show']);
                $menu->add('<i class="fa fa-envelope"></i><span>Email Settings</span>', ['route' => 'settings.email']);
				$menu->add('<i class="fa fa-dot-circle-o"></i><span>Findables</span>', ['route' => 'findables.index']);
                $menu->add('<i class="fa fa-pencil"></i><span>Email Templates</span>', ['route' => 'settings.templates']);
                $menu->add('<i class="fa fa-terminal"></i><span>API Keys</span>', ['route' => 'apikeys.index']);
        });

        return $next($request);
    }
}
