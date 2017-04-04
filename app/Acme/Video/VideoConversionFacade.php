<?php

namespace App\Acme\Video;

use App\Acme\Video\Handlers\Docker\Docker;
use App\Models\File;
use GrahamCampbell\Flysystem\Facades\Flysystem;

class VideoConversionFacade {

    /**
     * VideoConversionFacade constructor.
     * @param $file_id
     * @param $operations
     */
    public function __construct($file_id, $operations)
    {
        $this->row = File::findOrFail($file_id);
    }

    /**
     * @return bool
     */
    public function process()
    {
        // The check on the already converted file
        $converted_row = $this->row->hasConvert('ffmpeg');

        if($converted_row)
            return $converted_row;

        $file = Flysystem::read($this->row->getKey());
        $file = $this->ffmpeg($file, null);

        if($result = $this->row->saveResult($file, 'ffmpeg', 'video'))
            return $result;
        return false;

    }

    /**
     * @param $file
     * @param null $arguments
     * @return bool|string
     */
    public function ffmpeg($file, $arguments = null)
    {
        $instance = new Docker($file, $arguments);
        return $instance->ffmpeg();
    }
}