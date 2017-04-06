<?php

namespace App\Acme\Video\Handlers\Docker;

use App\Acme\Helpers\Uuid;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Docker {

    public $file;
    public $arguments = null;
    public $storagePath = 'temp';

    /**
     * Docker constructor.
     * @param $file
     * @param $arguments
     */
    public function __construct($file, $arguments)
    {
        $this->file = $file;
        if($arguments)
            $this->arguments = $arguments = array_filter(explode(',', $arguments));
    }

    /**
     * @return bool|string
     */
    public function webm()
    {
        $uuid = new Uuid(1);
        $filename = $uuid->generate();

        $folder = $this->storagePath.'/'.$filename;

        File::makeDirectory(storage_path($folder));

        $process = new Process('docker run opencoconut/ffmpeg -i http://files.coconut.co.s3.amazonaws.com/test.mp4 -f webm -c:v libvpx -c:a libvorbis - > '.storage_path($folder.'/'.$filename));
        //$process = new Process('docker run -v=`pwd`:/tmp/ffmpeg opencoconut/ffmpeg -i '.$this->file.' '.storage_path($folder.'/'.$filename));
        $process->setTimeout(1000);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $filename;

    }
}