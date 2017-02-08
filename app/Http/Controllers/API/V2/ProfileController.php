<?php

namespace App\Http\Controllers\API\V2;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Return info of logged in user.
     *
     * @param Request $request
     *
     * @return User
     */
    public function index(Request $request)
    {
        return auth()->guard('api')->user();
    }

    /**
     * Update info of logged in user.
     *
     * @param Request $request
     *
     * @return User
     */
    public function update(Request $request)
    {
        $user = auth()->guard('api')->user();
        $user->update($request->only(['name', 'email']));

        return $user;
    }
}
