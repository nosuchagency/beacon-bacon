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
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Menu::make('AdminMenu', function ($menu) {

            if (!Auth::check()) {
                return;
            }

            $menu->add('<i class="fa fa-dashboard"></i><span>' . __('Dashboard') . '</span>', ['route' => 'home']);

            $menu->raw(__('PLACES'), ['class' => 'header']);
            foreach (Place::all() as $index => $place) {
                $menu->add('<i class="fa fa-globe"></i><span>' . $place->name . '</span>', ['route' => ['places.show', $place->id]]);

                if ($index == 4) {
                    $menu->add('<i class="fa fa-circle-o text-aqua"></i><span>' . __('All places') . '</span>', ['route' => 'places.index']);
                    break;
                }
            }
            $menu->add('<i class="fa fa-plus"></i><span>' . __('Add New') . '</span>', ['route' => 'places.create']);

            $menu->raw(__('POINT OF INTERESTS'), ['class' => 'header']);
            $menu->add('<i class="fa fa-map-marker"></i><span>' . __('All POIs') . '</span>', ['route' => 'pois.index']);
            $menu->add('<i class="fa fa-plus"></i><span>' . __('Add New') . '</span>', ['route' => 'pois.create']);

            $menu->raw(__('BUILDING BLOCKS'), ['class' => 'header']);
            $menu->add('<i class="fa fa-square"></i><span>' . __('All Blocks') . '</span>', ['route' => 'blocks.index']);
            $menu->add('<i class="fa fa-plus"></i><span>' . __('Add New') . '</span>', ['route' => 'blocks.create']);

            $menu->raw(__('BEACONS'), ['class' => 'header']);
            $menu->add('<i class="fa fa-bullseye"></i><span>' . __('All Beacons') . '</span>', ['route' => 'beacons.index']);
            $menu->add('<i class="fa fa-plus"></i><span>' . __('Add New') . '</span>', ['route' => 'beacons.create']);
            $menu->add('<i class="fa fa-cloud-download"></i><span>' . __('Import Beacons') . '</span>', ['route' => 'beacons.import']);

            $menu->raw(__('SETTINGS'), ['class' => 'header']);

            if (Auth::user()->teams()->count() <> 1) {
                $menu->add('<i class="fa fa-users"></i><span>' . __('Teams') . '</span>', ['route' => 'teams.index']);
            }

            if (Auth::user()->isOwnerOfCurrentTeam()) {
                $menu->add('<i class="fa fa-users"></i><span>' . __('Users') . '</span>', ['route' => 'teams.members.show']);
                $menu->add('<i class="fa fa-envelope"></i><span>' . __('Email Settings') . '</span>', ['route' => 'settings.email']);
                $menu->add('<i class="fa fa-dot-circle-o"></i><span>' . __('Findables') . '</span>', ['route' => 'findables.index']);
                $menu->add('<i class="fa fa-pencil"></i><span>' . __('Email Templates') . '</span>', ['route' => 'settings.templates']);
                $menu->add('<i class="fa fa-terminal"></i><span>' . __('API Keys') . '</span>', ['route' => 'apikeys.index']);
            }
        });

        return $next($request);
    }
}
