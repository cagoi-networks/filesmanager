<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Illuminate\Support\Facades\File as  FileFacade;

class Conversions extends Model
{
    protected $table = 'conversions';

    protected $fillable = ['file_id', 'type', 'arguments', 'mime_type'];

    protected $storagePath = 'app/conversions';

    /**
     * @param $converted_file
     * @param $file
     * @param $operation
     * @param $arguments
     * @return object|null
     */
    public function saveResult($converted_file, $file, $operation, $arguments)
    {
        $data = array();
        $data ['file_id'] = $file->id;
        $data['type'] = $operation;
        $data['arguments'] = $arguments;
        $data['mime_type'] = $file->mime_type;
        if($row = $this->create($data))
        {
            $converted_file->save(storage_path($this->storagePath.'/'.$row->id));
            return $row;
        }
        return null;
    }

    /**
     * @param $file
     * @param $conversion
     * @return object
     */
    public static function getConvertedFile($file, $conversion)
    {
        $row = $file->conversions()->where('type', $conversion)->orderBy('created_at','desc')->first();
        return $row;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return FileFacade::get(storage_path($this->storagePath.'/'.$this->id));
    }
}
