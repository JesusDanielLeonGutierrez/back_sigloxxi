<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class VerifyTokenAccess extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('isValidToken');
//    }

    public function index() {
        $user=Auth::user();

        return response()->json($user);
    }

}
