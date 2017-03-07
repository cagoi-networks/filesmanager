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
            foreach ($this->conversions as $conversion_type => $arguments)
            {
                // The check on the already converted file
                $result = $this->file->hasConvert($conversion_type, $arguments);
                if(!$result)
                {
                    $arg = explode('x',$arguments);
                    if($this->file)
                    {
                        $this->converted_file = Image::make($this->file->getPath())->$conversion_type(
                            isset($arg[0]) ? $arg[0] : null,
                            isset($arg[1]) ? $arg[1] : null,
                            isset($arg[2]) ? $arg[2] : null,
                            isset($arg[3]) ? $arg[3] : null,
                            isset($arg[4]) ? $arg[4] : null,
                            isset($arg[5]) ? $arg[5] : null,
                            isset($arg[6]) ? $arg[6] : null,
                            isset($arg[7]) ? $arg[7] : null,
                            isset($arg[8]) ? $arg[8] : null,
                            isset($arg[9]) ? $arg[9] : null
                        );
                    }
                    $this->file = $conversions->saveResult($this->converted_file, $this->file, $conversion_type, $arguments);
                }
                else{
                    $this->file = $result;
                }
            }
            return $this->file;
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