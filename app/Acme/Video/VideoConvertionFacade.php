<?php

/**
 * Created by PhpStorm.
 * User: Bekturov Mirlan amanturovich@gmail.com
 * Date: 02.04.17
 * Time: 22:52
 */

namespace App\Acme\Video;

use App\Acme\Video\Handlers\Docker\Docker;
use App\Models\File;
use GrahamCampbell\Flysystem\Facades\Flysystem;

class VideoConvertionFacade {

    public function __construct($file_id, $operations)
    {
        $this->row = File::findOrFail($file_id);
    }

    public function process()
    {
        return $this->row;
//        $file = Flysystem::read($this->row->getKey());
//        $this->ffmpeg($file, null);
    }

    public function ffmpeg($file, $arguments = null)
    {
        $instance = new Docker($file, $arguments);
        return $instance->ffmpeg();
    }
}