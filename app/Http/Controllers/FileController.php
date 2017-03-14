<?php

namespace App\Http\Controllers;

use App\Acme\Image\ImageConvertionFacade;

class FileController extends Controller
{

    /**
     * @param $id
     * @param null $operations
     * @return bool|\Illuminate\Http\Response
     */
    public function show($id, $operations = null)
    {
        $image = new ImageConvertionFacade($id, $operations);
        if($result = $image->process())
            return response()->make($result->getPath(), 200, ['Content-Type' => $result->mime_type]);
        return false;
    }
}
