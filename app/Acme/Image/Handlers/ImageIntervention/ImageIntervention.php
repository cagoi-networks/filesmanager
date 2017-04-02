<?php

namespace App\Acme\Image\Handlers\ImageIntervention;

class ImageIntervention {

    public $file;
    public $arguments = null;

    /**
     * ImageIntervention constructor.
     * @param $file;
     * @param $arguments
     */
    public function __construct($file, $arguments)
    {
        $this->file = $file;
        if($arguments)
            $this->arguments = $arguments = array_filter(explode(',', $arguments));
    }

    /**
     * @return mixed
     */
    public function crop()
    {
        return $this->file->crop(
            isset($this->arguments[0]) ? intval($this->arguments[0]) : $this->file->width(),
            isset($this->arguments[1]) ? intval($this->arguments[1]) :$this->file->height(),
            isset($this->arguments[2]) ? intval($this->arguments[2]) : null,
            isset($this->arguments[3]) ? intval($this->arguments[3]) : null
        );
    }

    /**
     * @return mixed
     */
    public function rotate()
    {

        return $this->file->rotate(
            isset($this->arguments[0]) ? intval($this->arguments[0]) : null,
            '#0e0e0e'
        );
    }

    /**
     * @return mixed
     */
    public function grayscale()
    {
        return $this->file->greyscale();
    }

    /**
     * @return mixed
     */
    public function flip()
    {
        return $this->file->flip(
            isset($this->arguments[0]) ? $this->arguments[0] : 'h'
        );
    }
}