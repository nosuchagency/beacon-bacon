<?php

namespace App\Http\Controllers\Teamwork;

Use App\User;
use Illuminate\Http\Request;
use Mpociot\Teamwork\TeamInvite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the members of the given team.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $teamModel = config('teamwork.team_model');
        $team = $teamModel::findOrFail(auth()->user()->current_team_id);

        if (!auth()->user()->isOwnerOfTeam($team)) {
            abort(401);
        }

        return view('teamwork.members.list')->withTeam($team);
    }

    /**
     * Create a user and put it on the current team..
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $team = auth()->user()->currentTeam;
        $user->teams()->attach($team);
        $user->switchTeam($team);

        return redirect(route('teams.members.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $user_id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function uninvite($user_id)
    {
        $teamModel = config('teamwork.team_model');
        $team_id = auth()->user()->current_team_id;
        $team = $teamModel::findOrFail($team_id);
        if (!auth()->user()->isOwnerOfTeam($team)) {
            abort(403);
        }

        $userModel = config('teamwork.user_model');
        $user = $userModel::findOrFail($user_id);
        if ($user->getKey() === auth()->user()->getKey()) {
            abort(403);
        }

        $user->detachTeam($team);

        if ($user->teams()->count() == 0) {
            $user->delete();
        }

        return redirect(route('teams.members.show'));
    }

    /**
     * Delete a user.
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function destroy($user_id)
    {
        $userModel = config('teamwork.user_model');
        $user = $userModel::findOrFail($user_id);

        if ($user->teams()->count() > 1) {
            // Dont allow delete if user is in more teams
            return redirect(route('teams.members.show'));
        }

        foreach ($user->teams as $team) {
            $user->detachTeam($team);
        }

        $user->delete();
        return redirect(route('teams.members.show'));
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function invite(Request $request)
    {
        $teamModel = config('teamwork.team_model');
        $team_id = auth()->user()->current_team_id;
        $team = $teamModel::findOrFail($team_id);

        if( !Teamwork::hasPendingInvite( $request->email, $team) )
        {
            Teamwork::inviteToTeam( $request->email, $team, function( $invite )
            {
                Mail::send('teamwork.emails.invite', ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
                    $m->to($invite->email)->subject('Invitation to join team '.$invite->team->name);
                });
                // Send email to user
            });
        } else {
            return redirect()->back()->withErrors([
                'email' => 'The email address is already invited to the team.'
            ]);
        }

        return redirect(route('teams.members.show'));
    }

    /**
     * Resend an invitation mail.
     *
     * @param $invite_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resendInvite($invite_id)
    {
        $invite = TeamInvite::findOrFail($invite_id);
        Mail::send('teamwork.emails.invite', ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
            $m->to($invite->email)->subject('Invitation to join team '.$invite->team->name);
        });

        return redirect(route('teams.members.show'));
    }

    /**
     * Delete an invitation.
     *
     * @param $invite_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteInvite($invite_id)
    {
        $invite = TeamInvite::findOrFail($invite_id);
        $invite->delete();
        return redirect(route('teams.members.show'));
    }
}
