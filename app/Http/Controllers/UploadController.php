<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $fileModel = new File();
        if($request->file('files')){
            foreach ($request->file('files') as $file){
                if($url = $fileModel->upload($file)){
                    return response()->json(['url' => $url]);
                }
            }
        }
        return false;
    }
}
