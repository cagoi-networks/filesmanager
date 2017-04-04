<?php

namespace App\Models;

use App\Acme\Helpers\Uuid;
use Carbon\Carbon;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use Intervention\Image\Facades\Image;

class Import extends Model
{
    protected $collection = 'imports';
    protected $fillable = ['old_id','project_id','url', 'user_id', 'status', 'error_message','file_id','imported_at'];
    protected $hidden = ['user_id', 'updated_at'];

    /**
     * @return bool
     */
    public function importing()
    {
        $rows = $this->where('status', 'wait')->take(100)->get();

        if($rows->isEmpty())
            return false;

        foreach ($rows as $row)
        {
            $this->_saveFile($row);
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGetForImport($query)
    {
        return $query->where('status', 'wait')->take(100)->get();
    }

    /**
     * @param $query
     * @param $user
     * @return mixed
     */
    public function scopeFindByUser($query, $user)
    {
        return $query->where('user_id', $user->getKey())->get();
    }

    /**
     * @param $row
     */
    private function _saveFile($row)
    {
        $uuid = new Uuid(1);
        $file_id = $uuid->generate();
        $file = new File();
        $data = array();
        $error_message = null;
        $status = 'error';


        $response = $this->_filexists($row->url);
        $project = Project::find($row->project_id);

        if($response === true && $project)
        {
            $image =  Image::make($row->url);
            $image->encode();
            Flysystem::put($file_id, $image);

            $file->file_id = $file_id;
            $file->user_id = $row->user_id;
            $file->project_id = $project->getKey();
            $file->mime_type = Flysystem::getMimetype($file_id);
            $file->size = Flysystem::getSize($file_id);

            if($file->save())
            {
                $data['file_id'] = $file_id;
                $data['imported_at'] = Carbon::now();
                $status = 'success';
            }
        }

        if(!$project)
            $error_message = 'Project '.$row->project_id.' not found';

        if($response !== true)
            $error_message = $error_message.'; '.$response;

        $data['status'] = $status;
        $data['errors_message'] = trim($error_message, ';');
        $row->update($data);
    }

    /**
     * @param $url
     * @return bool
     */
    private function _filexists($url)
    {
        $headers = get_headers($url);
        return stripos($headers[0],"200 OK") ? true : $headers[0];
    }
}
