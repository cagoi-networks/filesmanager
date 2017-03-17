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
        if(!$this->_validate())
            abort(404, 'Not image file');

        if(!$this->operations)
            return $this->row;

        $converted_row = $this->row;
        $conversions = new Conversions();

        foreach ($this->operations as $operation => $arguments)
        {
            if(!method_exists($this, $operation) )
                abort(404, 'Url parse error');

            // The check on the already converted file
            $hasConvert = $this->row->hasConvert($operation, $arguments);

            if($hasConvert)
            {
                $converted_row = $hasConvert;
            }
            else
            {
                $converted_file = $this->$operation($converted_row, $arguments);

                if($converted_file)
                    $converted_row = $conversions->saveResult($converted_file, $this->row, $operation, $arguments);
            }
        }
        return $converted_row;
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