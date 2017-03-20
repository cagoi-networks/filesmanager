<?php

namespace App\Acme\Image;

use App\Acme\Helpers\UrlParser;
use App\Acme\Image\Handlers\ImageIntervention\ImageIntervention;
use App\Models\File;

class ImageConvertionFacade {


    private $row;
    private $operations;
    private $mime_types = ['jpeg','jpg','png','gif'];
    /**
     * ImageConvertionFacade constructor.
     * @param $file_id
     * @param $operations
     */
    public function __construct($file_id, $operations)
    {
        $this->row = File::findOrFail($file_id);
        $urlParser = new UrlParser($operations);
        $this->operations = $urlParser->get();
    }

    /**
     * @return object|bool
     */
    public function process()
    {
        if(!$this->_validate())
            abort(404, 'Not image file');

        if(!$this->operations)
            return $this->row;

        foreach ($this->operations as $operation => $arguments)
        {
            if(!method_exists($this, $operation) )
                abort(404, 'Url parse error');

            // The check on the already converted file
            $converted_row = $this->row->hasConvert($operation, $arguments);

            if($converted_row)
            {
                $this->row = $converted_row;
            }
            else
            {
                $converted_file = $this->$operation($this->row, $arguments);

                if($converted_file)
                    $this->row = $this->row->saveResult($converted_file, $operation, $arguments);
            }
        }
        return $this->row;
    }


    /**
     * @param $row
     * @param null $arguments
     * @return string
     */
    public function crop($row, $arguments = null)
    {
        $instance = new ImageIntervention($row, $arguments);
        return $instance->crop();
    }


    /**
     * @param $row
     * @param null $arguments
     * @return string
     */
    public function rotate($row, $arguments = null)
    {
        $instance = new ImageIntervention($row, $arguments);
        return $instance->rotate();
    }


    /**
     * @param $row
     * @param null $arguments
     * @return string
     */
    public function grayscale($row, $arguments = null)
    {
        $instance = new ImageIntervention($row, $arguments);
        return $instance->grayscale();
    }


    /**
     * @param $row
     * @param null $arguments
     * @return string
     */
    public function flip($row, $arguments = null)
    {
        $instance = new ImageIntervention($row, $arguments);
        return $instance->flip();
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