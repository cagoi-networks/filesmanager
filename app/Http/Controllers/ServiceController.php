<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class ServiceController extends Controller
{
    public function service($drive)
    {
        return response()->json(true);
        //return response()->json(['authenticated'=>true]);
    }

    public function connect($drive)
    {
        return response()->json(true);
        //return Socialite::with($drive)->redirect();
    }
}
