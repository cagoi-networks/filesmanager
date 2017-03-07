<?php

namespace App\Helpers;

use App\Converting\ImageConverting;
use App\Models\File;

class Image {

    public static function get($id, $conversion = null, $arguments = null)
    {
        $file = File::findOrFail($id);
        $data['mime_type'] = $file->mime_type;

        // Getting of converted file
        if($conversion)
        {
            // Conversion
            $imageConverting = new ImageConverting($file, [
                $conversion => $arguments
            ]);

            // Get converted file and show
            if($result = $imageConverting->process()){
                $data ['path'] = $result->getPath();
                return $data;
            }
        }
        $data ['path'] = $file->getPath();
        return $data;
    }
}