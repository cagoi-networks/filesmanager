<?php

/**
 * Created by PhpStorm.
 * User: Bekturov Mirlan amanturovich@gmail.com
 * Date: 02.04.17
 * Time: 22:54
 */

namespace App\Acme\Video\Handlers\Docker;

class Docker {

    public $file;
    public $arguments = null;

    public function __construct($file, $arguments)
    {
        $this->file = $file;
        if($arguments)
            $this->arguments = $arguments = array_filter(explode(',', $arguments));
    }

    public function ffmpeg()
    {
        return exec('sudo docker run opencoconut/ffmpeg -i http://files.coconut.co.s3.amazonaws.com/test.mp4 -f webm -c:v libvpx -c:a libvorbis - > test.webm');
    }
}