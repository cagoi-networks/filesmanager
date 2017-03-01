<?php

namespace App\Http\Controllers;

class ServiceController extends Controller
{
    public function service($id)
    {
        return response()->json(['id' => $id]);
    }
}
