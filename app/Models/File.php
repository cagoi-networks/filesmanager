<?php

namespace App\Models;

use App\Acme\Helpers\Uuid;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class File extends Model
{
    protected $collection = 'files';

    protected $primaryKey = 'file_id';

    protected $fillable = ['file_id','name', 'extension', 'mime_type', 'size', 'operation', 'arguments', 'original_id'];

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
     * @param $converted_file
     * @param $operation
     * @param $arguments
     * @return object|null
     */
    public function saveResult($converted_file, $operation, $arguments)
    {
        $data = array();

        $data['file_id'] = $converted_file;
        $data['name'] = $converted_file;
        $data['mime_type'] = Flysystem::getMimetype($converted_file);
        $data['size'] = Flysystem::getSize($converted_file);
        $data['operation'] = $operation;
        $data['arguments'] = $arguments;
        $data['original_id'] = $this->getKey();

        if($row = $this->create($data))
            return $row;

        return null;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return Flysystem::read($this->getKey());
    }

    /**
     * @param $operation
     * @param $arguments
     * @return object|bool
     */
    public function hasConvert($operation, $arguments)
    {
        return $this->where('operation', $operation)->where('arguments', $arguments)->where('original_id', $this->getKey())->first();
    }


}
