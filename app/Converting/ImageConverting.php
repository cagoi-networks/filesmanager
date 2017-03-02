<?php

namespace App\Converting;

use App\Models\Conversions;
use Intervention\Image\Facades\Image;

class ImageConverting{

    public $file;
    public $conversions;
    public $mimes = ['jpeg','jpg','png','gif'];
    public $converted_file;

    public function __construct($file, $conversions)
    {
        $this->file = $file;
        $this->conversions = $conversions;
    }

    public function process()
    {
        if($this->_validate($this->file))
        {
            $conversions = new Conversions();
            $image = $this->file->getPath();
            foreach ($this->conversions as $conversion_type => $arguments)
            {
                if($image)
                {
                    $this->converted_file = Image::make($image)->$conversion_type(
                        isset($arguments[0]) ? $arguments[0] : null,
                        isset($arguments[1]) ? $arguments[1] : null,
                        isset($arguments[2]) ? $arguments[1] : null,
                        isset($arguments[3]) ? $arguments[1] : null,
                        isset($arguments[4]) ? $arguments[1] : null,
                        isset($arguments[5]) ? $arguments[1] : null,
                        isset($arguments[6]) ? $arguments[1] : null,
                        isset($arguments[7]) ? $arguments[1] : null,
                        isset($arguments[8]) ? $arguments[1] : null,
                        isset($arguments[9]) ? $arguments[1] : null
                    );
                }
                $image = $conversions->saveResult($this->converted_file, $this->file, $conversion_type);
            }
        }
        return false;
    }

    private function _validate($file)
    {

        if (in_array($file->extension, $this->mimes))
          return true;

        return false;
    }
}