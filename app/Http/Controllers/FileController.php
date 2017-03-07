<?php

namespace App\Http\Controllers;

use App\Helpers\Image;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function show($id, $conversion = null, $arguments = null)
    {
        $result = Image::get($id, $conversion, $arguments);
        if($result)
            return Response::make($result['path'])->header('Content-Type', $result['mime_type']);
        return false;
    }
}
