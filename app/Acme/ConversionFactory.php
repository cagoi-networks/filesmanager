<?php

namespace App\Acme;

use App\Models\File;

class ConversionFactory {

    /**
     * @param $file_id
     * @param $operations
     * @return mixed
     * @throws \Exception
     */
    public static function build($file_id, $operations)
    {
        $file = File::findOrFail($file_id);
        $type = explode('/',$file->mime_type);

        $class = 'App\\Acme\\'.ucfirst($type[0]).'\\'.ucfirst($type[0].'ConversionFacade');

        if(class_exists($class))
        {
            return new $class($file->file_id, $operations);
        }
        else
        {
            throw new \Exception("Class $class not found");
        }
    }
}