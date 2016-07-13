<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return auth()->guard('api')->user();
    }
}
