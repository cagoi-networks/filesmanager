<?php

namespace App\Acme\Video;

use App\Acme\Helpers\UrlParser;
use App\Acme\Video\Handlers\Docker\Docker;
use App\Models\File;

class VideoConversionFacade {

    private $row;
    private $operations;

    /**
     * @param $file_id
     * @param $operations
     * @return array
     */
    public function process($file_id, $operations)
    {
        $this->row = File::findOrFail($file_id);
        $urlParser = new UrlParser($operations);
        $this->operations = $urlParser->get();

        if(!$this->operations)
            return $this->row;

        // The check on the already converted file
        $converted_row = $this->row->hasConvert($this->operations);

        if($converted_row)
            return $converted_row;
        else
            abort(404, 'File not found');

    }

    /**
     * @param $file
     * @param null $arguments
     * @return bool|string
     */
    public function webm($file, $arguments = null)
    {
        $object = new Docker($file, $arguments);
        return $object->webm();
    }
}