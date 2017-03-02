<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Illuminate\Support\Facades\File as  FileFacade;

class Conversions extends Model
{
    protected $table = 'conversions';

    protected $fillable = ['file_id', 'type'];

    protected $storagePath = 'app/conversions';

    public function saveResult($converted_file, $file, $conversion_type)
    {
        $data = array();
        $data ['file_id'] = $file->id;
        $data['type'] = $conversion_type;
        if($row = $this->create($data))
        {
            $converted_file->save(storage_path($this->storagePath.'/'.$row->id));
            return $row->getPath();
        }
        return null;
    }

    public static function getConvertedFile($file, $conversion)
    {
        $row = $file->conversions()->where('type', $conversion)->orderBy('created_at','desc')->first();
        return $row;
    }

    public function getPath()
    {
        return FileFacade::get(storage_path($this->storagePath.'/'.$this->id));
    }
}
