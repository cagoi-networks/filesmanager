<?php

namespace App\Http\Controllers;

use App\Acme\ConvertionFactory;

class FileController extends Controller
{

    /**
     * @param $file_id
     * @param null $operations
     * @return bool|\Illuminate\Http\Response
     */
    public function show($file_id, $operations = null)
    {
        $file = ConvertionFactory::build($file_id, $operations);
        if($result = $file->process())
            return response()->make($result->getFile(), 200, ['Content-Type' => $result->mime_type]);
        return false;
    }
}
