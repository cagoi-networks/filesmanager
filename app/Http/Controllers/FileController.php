<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function show($id)
    {
        $file = File::findOrFail($id);
        $path = $file->getPath();
        return Response::make($path)->header('Content-Type', $file->mime_type);
    }
}
