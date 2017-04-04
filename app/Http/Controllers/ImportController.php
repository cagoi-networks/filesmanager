<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\User;
use Illuminate\Http\Request;;

class ImportController extends Controller
{
    /**
     * @param Request $request
     */
    public function process(Request $request)
    {
        $this->_validate($request);

        $import = new Import();

        $user = User::findByToken($request->json('api_token'));

        if(!$user->exists())
            abort(404, 'Invalid API token');

        foreach ($request->json('data') as $data)
        {
            $data['url'] = htmlspecialchars( clean( $data['url'], 'noHtml'), ENT_QUOTES );
            $data['user_id'] = $user->getKey();
            $data['status'] = 'wait';
            $import->create($data);
        }
    }

    /**
     * @param $api_token
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($api_token)
    {
        $user = User::findByToken($api_token);

        if(!$user->exists())
            abort(404, 'Invalid API token');

        $files = Import::findByUser($user);

        return response()->json($files);
    }

    /**
     * @param Request $request
     */
    private function _validate(Request $request)
    {
        if(!$request->isJson())
            abort(404, 'Invalid JSON recieved');

        if(empty($request->json('data')))
            abort(404, 'The request does not have data');

        if(empty($request->json('api_token')))
            abort(404, 'The request does not have a api token');
    }
}
