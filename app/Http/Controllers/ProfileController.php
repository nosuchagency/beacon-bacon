<?php

namespace App\Http\Controllers;

use Hash;
use App\Http\Requests;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the profile info
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $user->update($request->all());
        return redirect()->route('profile');
    }

    /**
     * Update the password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = auth()->user();

        // Check against the old password
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->route('profile')->withErrors(collect(['old_password' => 'The old password entered is not correct']));
        }

        // Saved a hashed version of the new password (never cleartext!)
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('profile');
    }

    public function storeApi(Request $request)
    {
        return redirect()->route('profile');
    }

    public function destroyApi(Request $request, $id)
    {
        return redirect()->route('profile');
    }
}
