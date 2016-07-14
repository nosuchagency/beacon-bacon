<?php

namespace App\Http\Controllers;

use App\User;
use App\ApiKey;
use Illuminate\Http\Request;
use Mpociot\Teamwork\Traits\UsedByTeams;

class ApiController extends Controller
{
    use UsedByTeams;

    public function index()
    {
        $keys = ApiKey::all();
        $users = auth()->user()->currentTeam->users()->orderBy('name')->lists('name', 'id');

        return view('apikeys.index', compact('keys', 'users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        ApiKey::create([
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id'),
            'api_token' => bcrypt($request->input('name') . $request->input('user_id') . 'bacon' . time())
        ]);

        return redirect()->route('apikeys.index');
    }

    public function destroy($id)
    {
        ApiKey::findOrFail($id)->delete();
        return redirect()->route('apikeys.index');
    }
}
