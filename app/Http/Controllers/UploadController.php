<?php

namespace App\Http\Controllers;

use App\Acme\Helpers\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $url = Upload::process($request);
        if($url)
            return response()->json(['url' => $url]);
        return false;
    }
}
