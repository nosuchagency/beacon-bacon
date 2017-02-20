<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Setting;

class ConfigLoader
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
        $settings = null;

        // check if user is logged in
        if (auth()->check()) {
            // get the settings in a nice key=>value format
            $settings = Setting::pluck('value', 'key');
        }
        // check for email input (ie. forgot password)
        elseif ($request->input('email')) {
            $user = User::whereEmail($request->input('email'))->first();

            if ($user) {
                $settings = Setting::withoutGlobalScopes()->whereTeamId($user->current_team_id)->pluck('value', 'key');
            }
        }

        if ($settings) {
            // set the config
            config($settings->toArray());

            // make the mail provider reload the config
            (new \Illuminate\Mail\MailServiceProvider(app()))->register();
        }

        if (auth()->guard('api')->check()) {
            config(['laravel-activitylog.guard' => 'api']);
            (new \Spatie\Activitylog\ActivitylogServiceProvider(app()))->register();
        }

        return $next($request);
    }
}
