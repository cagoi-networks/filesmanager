<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use Illuminate\Support\Facades\File as  FileFacade;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = ['name', 'extension', 'mime_type', 'size'];

    protected $storagePath = 'uploads';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversions()
    {
        return $this->hasMany(Conversions::class);
    }

    /**
     * @param $file
     * @return object|bool
     */
    public function upload($file)
    {
        $data = array();
        $data['name'] = $file->getClientOriginalName();
        $data['extension'] = $file->getClientOriginalExtension();
        $data['mime_type'] = $file->getClientMimeType();
        $data['size'] = $file->getClientSize();
        if($row = $this->create($data))
        {
            Storage::putFileAs(
                $this->storagePath, $file, $row->id
            );
            return $row;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return FileFacade::get(storage_path('app/'.$this->storagePath.'/'.$this->id));
    }

    /**
     * @param $operation
     * @param $arguments
     * @return object|bool
     */
    public function hasConvert($operation, $arguments)
    {
        $item = $this->conversions()->where('type', $operation)->where('arguments', $arguments)->first();
        if($item)
            return $item;
        return false;
    }


}
