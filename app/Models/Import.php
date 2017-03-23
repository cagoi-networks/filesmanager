<?php

namespace App\Models;

use Carbon\Carbon;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use Intervention\Image\Facades\Image;

class Import extends Model
{
    protected $collection = 'imports';

    protected $primaryKey = 'file_id';

    protected $fillable = ['file_id','url', 'user_id', 'mime_type', 'size', 'imported_at'];

    public function importing()
    {
        $rows = $this->where('imported_at', null)->take(100)->get();

        if($rows->isEmpty())
            return false;

        foreach ($rows as $row)
        {
            if($this->_filexists($row))
                $this->_saveFile($row);
        }
    }

    private function _filexists($row)
    {
        $headers = get_headers($row->url);
        return stripos($headers[0],"200 OK") ? true : false;
    }

    private function _saveFile($row)
    {
        $image =  Image::make($row->url);
        $image->encode();
        Flysystem::put($row->file_id, $image);

        $data['mime_type'] = Flysystem::getMimetype($row->file_id);
        $data['size'] = Flysystem::getSize($row->file_id);
        $data['imported_at'] = Carbon::now();

        $row->update($data);
    }
}
