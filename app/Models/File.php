<?php

namespace App\Models;

use App\Acme\Helpers\Uuid;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class File extends Model
{
    protected $collection = 'files';

    protected $primaryKey = 'file_id';

    protected $fillable = ['file_id','name', 'mime_type', 'size', 'operation', 'arguments', 'original_id'];

    protected $storagePath = 'files';

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

        if($row = $this->create($data))
            return $row;

        return false;
    }

    /**
     * @param $image
     * @param $operation
     * @return object|bool
     */
    public function saveResult($file, $operation)
    {
        $uuid = new Uuid(1);
        $filename = $uuid->generate();

        $file->encode();
        Flysystem::put($filename, $file);

        $data = array();

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


}
