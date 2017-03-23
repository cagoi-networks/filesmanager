<?php

namespace App\Http\Controllers;

use App\Acme\Helpers\Uuid;
use App\Models\Import;
use Illuminate\Http\Request;;

class ImportController extends Controller
{
    public function process(Request $request)
    {
        if(!$request->isJson())
            abort(404, 'Invalid JSON recieved');

        if(empty($request->json('data')))
            abort(404, 'Empty JSON data');

        if(empty($request->json('api_token')))
            abort(404, 'Invalid API token');

        $import = new Import();
        $uuid = new Uuid(1);

        foreach ($request->json('data') as $data)
        {
            $data['file_id'] = $uuid->generate();;
            $data['url'] = htmlspecialchars( clean( $data['url'], 'noHtml'), ENT_QUOTES );
            $data['user_id'] = 1;
            $import->create($data);
        }
    }
}
