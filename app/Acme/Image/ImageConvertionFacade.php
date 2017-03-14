<?php

namespace App\Acme\Image;

use App\Acme\Helpers\UrlParser;
use App\Acme\Image\Handlers\ImageIntervention;
use App\Models\Conversions;
use App\Models\File;

class ImageConvertionFacade {


    private $row;
    private $operations;
    private $mimes = ['jpeg','jpg','png','gif'];

    /**
     * ImageConvertionFacade constructor.
     * @param $id
     * @param $operations
     */
    public function __construct($id, $operations)
    {
        $this->row = File::findOrFail($id);
        $urlParser = new UrlParser($operations);
        $this->operations = $urlParser->get();
    }

    /**
     * @return object|bool
     */
    public function process()
    {
        $converted_row = $this->row;

        if($this->_validate())
        {
            $conversions = new Conversions();
            if($this->operations)
            {
                foreach ($this->operations as $operation => $arguments)
                {
                    // The check on the already converted file
                    $hasConvert = $this->row->hasConvert($operation, $arguments);
                    if(!$hasConvert)
                    {
                        $converted_file = $this->$operation($converted_row, $arguments);
                        if($converted_file)
                            $converted_row = $conversions->saveResult($converted_file, $this->row, $operation, $arguments);
                    }
                    else
                    {
                        $converted_row = $hasConvert;
                    }
                }
            }
            return $converted_row;
        }
        return false;
    }


    /**
     * @param $row
     * @param null $arguments
     * @return mixed
     */
    public function crop($row, $arguments = null)
    {
        $instance = new ImageIntervention($row, $arguments);
        return $instance->crop();
    }


    /**
     * @param $row
     * @param null $arguments
     * @return mixed
     */
    public function rotate($row, $arguments = null)
    {
        $instance = new ImageIntervention($row, $arguments);
        return $instance->rotate();
    }


    /**
     * @param $row
     * @param null $arguments
     * @return mixed
     */
    public function grayscale($row, $arguments = null)
    {
        $instance = new ImageIntervention($row, $arguments);
        return $instance->grayscale();
    }


    /**
     * @param $row
     * @param null $arguments
     * @return mixed
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
        if (in_array($this->row->extension, $this->mimes))
            return true;
        return false;
    }
}