<?php

namespace App\Http\Controllers;

use App\Acme\ConversionFactory;

class FileController extends Controller
{

    /**
     * @param $file_id
     * @param null $operations
     * @return bool|\Illuminate\Http\Response
     */
    public function show($file_id, $operations = null)
    {
        $object = ConversionFactory::build($file_id);
        if($result = $object->process($file_id, $operations))
            return response()->make($result->getFile(), 200, ['Content-Type' => $result->mime_type]);
        return false;
    }
}
