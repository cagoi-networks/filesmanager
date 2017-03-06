<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class ServiceController extends Controller
{
    public function service($drive)
    {
        // $c = Socialite::driver($drive);
        // dd($c->user());
        return response()->json(true);
    }

    public function connect($drive)
    {
        return response()->json(true);
        //return Socialite::with($drive)->redirect();
    }
}
