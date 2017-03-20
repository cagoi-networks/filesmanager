<?php

namespace App\Acme\Image\Handlers\ImageIntervention;

use App\Acme\Helpers\Uuid;
use GrahamCampbell\Flysystem\Facades\Flysystem;
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
        $this->image = Image::make(Flysystem::read($this->row->getKey()));
        if($arguments)
            $this->arguments = $arguments = array_filter(explode(',', $arguments));
    }

    /**
     * @return mixed
     */
    public function crop()
    {
        $image =  $this->image->crop(
            isset($this->arguments[0]) ? $this->arguments[0] : $this->image->width(),
            isset($this->arguments[1]) ? $this->arguments[1] :$this->image->height(),
            isset($this->arguments[2]) ? $this->arguments[2] : null,
            isset($this->arguments[3]) ? $this->arguments[3] : null
        );

        if($file_id = $this->saveImage($image))
            return $file_id;

        return null;
    }

    /**
     * @return mixed
     */
    public function rotate()
    {

        $image =  $this->image->rotate(
            isset($this->arguments[0]) ? $this->arguments[0] : null,
            '#0e0e0e'
        );

        if($file_id = $this->saveImage($image))
            return $file_id;

        return null;
    }

    /**
     * @return mixed
     */
    public function grayscale()
    {
        $image = $this->image->greyscale();

        if($file_id = $this->saveImage($image))
            return $file_id;

        return null;
    }

    /**
     * @return mixed
     */
    public function flip()
    {
        $image = $this->image->flip(
            isset($this->arguments[0]) ? $this->arguments[0] : 'h'
        );

        if($file_id = $this->saveImage($image))
            return $file_id;

        return null;
    }

    private function saveImage($image)
    {
        $uuid = new Uuid(1);
        $file_id = $uuid->generate();

        $image->encode();
        Flysystem::put($file_id, $image);

        return $file_id;
    }
}