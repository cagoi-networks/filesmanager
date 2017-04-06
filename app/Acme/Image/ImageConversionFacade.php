<?php

namespace App\Acme\Image;

use App\Acme\Helpers\UrlParser;
use App\Acme\Image\Handlers\ImageIntervention\ImageIntervention;
use App\Models\File;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Intervention\Image\Facades\Image;

class ImageConversionFacade {

    private $row;
    private $operations;
    private $mime_types = ['jpeg','jpg','png','gif'];

    /**
     * @param $file_id
     * @param $operations
     * @return object|bool
     */
    public function process($file_id, $operations)
    {
        $this->row = File::findOrFail($file_id);
        $urlParser = new UrlParser($operations);
        $this->operations = $urlParser->get();

        if(!$this->_validate())
            abort(404, 'Not image file');

        if(!$this->operations)
            return $this->row;

        // The check on the already converted file
        $converted_row = $this->row->hasConvert($this->operations);

        if($converted_row)
           return $converted_row;

        $file = Image::make(Flysystem::read($this->row->getKey()));

        foreach ($this->operations as $operation => $arguments)
        {
            if(!method_exists($this, $operation) )
                abort(404, 'Url parse error');

            $file = $this->$operation($file, $arguments);
        }

        if($result = $this->row->saveResult($file, $this->operations, 'image'))
            return $result;
        return false;
    }


    /**
     * @param $file
     * @param null $arguments
     * @return string
     */
    public function crop($file, $arguments = null)
    {
        $object = new ImageIntervention($file, $arguments);
        return $object->crop();
    }


    /**
     * @param $file
     * @param null $arguments
     * @return string
     */
    public function rotate($file, $arguments = null)
    {
        $object = new ImageIntervention($file, $arguments);
        return $object->rotate();
    }


    /**
     * @param $file
     * @param null $arguments
     * @return string
     */
    public function grayscale($file, $arguments = null)
    {
        $object = new ImageIntervention($file, $arguments);
        return $object->grayscale();
    }


    /**
     * @param $file
     * @param null $arguments
     * @return string
     */
    public function flip($file, $arguments = null)
    {
        $object = new ImageIntervention($file, $arguments);
        return $object->flip();
    }


    /**
     * @return bool
     */
    private function _validate()
    {
        if (in_array(explode('/',$this->row->mime_type)[1], $this->mime_types))
            return true;
        return false;
    }
}