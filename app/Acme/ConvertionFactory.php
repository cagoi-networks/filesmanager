<?php

/**
 * Created by PhpStorm.
 * User: Bekturov Mirlan amanturovich@gmail.com
 * Date: 02.04.17
 * Time: 22:26
 */

namespace App\Acme;

use App\Models\File;

class ConvertionFactory {

    public static function build($file_id, $operations)
    {
        $file = File::findOrFail($file_id);
        $type = explode('/',$file->mime_type);

        $class = 'App\\Acme\\'.ucfirst($type[0]).'\\'.ucfirst($type[0].'ConvertionFacade');

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