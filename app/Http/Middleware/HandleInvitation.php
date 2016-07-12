<?php

namespace App\Http\Middleware;

use Closure;
use Teamwork;

class HandleInvitation
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
        if (session('invite_token') && auth()->check()) {
            if ($invite = Teamwork::getInviteFromAcceptToken(session('invite_token'))) {
                Teamwork::acceptInvite($invite);
            }
            session()->forget('invite_token');
        }

        return $next($request);
    }
}
