<?php

namespace App\Http\Controllers;

use App\Helpers\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $url = Upload::process($request);
        if($url)
            return response()->json(['url' => $url]);
        return false;
    }
}
