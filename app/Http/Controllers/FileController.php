<?php

namespace App\Http\Controllers;

use App\Converting\ImageConverting;
use App\Models\Conversions;
use App\Models\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function show($id, $conversion = null)
    {
        $file = File::findOrFail($id);

        // Getting of converted file
        if($conversion)
        {
            $convertedFile = Conversions::getConvertedFile($file, $conversion);

            if($convertedFile)
            {
                $path = $convertedFile->getPath();
                return Response::make($path)->header('Content-Type', $file->mime_type);
            }
        }

        // Conversion
        $imageConverting = new ImageConverting($file, [
            'crop' => [ 170,100 ],
            'rotate' => [ 90 ]

        ]);
        $imageConverting->process();

        $path = $file->getPath();
        return Response::make($path)->header('Content-Type', $file->mime_type);
    }
}
