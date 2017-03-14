<?php

namespace App\Acme\Image\Handlers;

use Intervention\Image\Facades\Image;

class ImageIntervention {

    public $arguments = null;
    public $row;
    public $image;

    /**
     * ImageIntervention constructor.
     * @param $row
     * @param $arguments
     */
    public function __construct($row, $arguments)
    {
        $this->row = $row;
        $this->image = Image::make($this->row->getPath());
        if($arguments)
            $this->arguments = $arguments = array_filter(explode(',', $arguments));
    }

    /**
     * @return mixed
     */
    public function crop()
    {
        return $this->image->crop(
            isset($this->arguments[0]) ? $this->arguments[0] : $this->image->width(),
            isset($this->arguments[1]) ? $this->arguments[1] :$this->image->height(),
            isset($this->arguments[2]) ? $this->arguments[2] : null,
            isset($this->arguments[3]) ? $this->arguments[3] : null
        );
    }

    /**
     * @return mixed
     */
    public function rotate()
    {

        return $this->image->rotate(
            isset($this->arguments[0]) ? $this->arguments[0] : null,
            '#0e0e0e'
        );
    }

    /**
     * @return mixed
     */
    public function grayscale()
    {
        return $this->image->greyscale();
    }

    /**
     * @return mixed
     */
    public function flip()
    {
        return  $this->image->flip(
            isset($this->arguments[0]) ? $this->arguments[0] : 'h'
        );
    }
}