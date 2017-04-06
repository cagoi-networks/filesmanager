<?php

namespace App\Models;

use App\Acme\Helpers\Uuid;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class File extends Model
{
    protected $collection = 'files';
    protected $primaryKey = 'file_id';
    protected $fillable = ['file_id','user_id', 'project_id','name', 'mime_type', 'size', 'operation', 'arguments', 'ready', 'original_id'];
    protected $tempPath = 'temp';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeGetVideoFiles($query)
    {
        return $query->where('mime_type', 'like', '%video%')->where('ready', null)->where('original_id', null)->get();
    }

    /**
     * @param $file
     * @return object|bool
     */
    public function upload($file)
    {
        $data = array();
        $uuid = new Uuid(1);
        $file_id = $uuid->generate();

        $stream = fopen($file->getRealPath(), 'r+');
        Flysystem::putStream($file_id, $stream);
        fclose($stream);

        $data['file_id'] = $file_id;
        $data['name'] = $file_id;
        $data['mime_type'] = Flysystem::getMimetype($file_id);
        $data['size'] = Flysystem::getSize($file_id);

        if(Auth::user())
            $data['user_id'] = Auth::user()->getKey();

        if($row = $this->create($data))
            return $row;

        return false;
    }

    /**
     * @param $file
     * @param $operation
     * @param $type
     * @return object|bool
     */
    public function saveResult($file, $operation, $type = null)
    {
        $filename = null;
        $data = array();

        if($type == 'image')
            $filename = $this->_saveImage($file);

        if($type == 'video')
        {
            $filename = $this->_saveVideo($file);
            $this->ready = true;
            $this->save();
        }


        $data['file_id'] = $filename;
        $data['mime_type'] = Flysystem::getMimetype($filename);
        $data['size'] = Flysystem::getSize($filename);
        $data['operation'] = $operation;
        $data['original_id'] = $this->getKey();

        if($row = $this->create($data))
            return $row;

        return false;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return Flysystem::read($this->getKey());
    }

    /**
     * Checking exist of a converted record and a file
     * @param $operation
     * @return object|bool
     */
    public function hasConvert($operation)
    {
        $row = $this->where('operation', $operation)->where('original_id', $this->getKey())->first();
        if($row && $row->getFile())
            return $row;
        return false;
    }

    /**
     * @param $file
     * @return bool|string
     */
    private function _saveImage($file)
    {
        $uuid = new Uuid(1);
        $filename = $uuid->generate();
        $file->encode();
        Flysystem::put($filename, $file);

        return $filename;
    }

    /**
     * @param $file
     * @return mixed
     */
    private function _saveVideo($file)
    {
        $folder = $this->tempPath.'/'.$file;
        $source = storage_path($folder.'/'.$file);
        $content = file_get_contents($source);
        Flysystem::put($file, $content);

        return $file;
    }
}
