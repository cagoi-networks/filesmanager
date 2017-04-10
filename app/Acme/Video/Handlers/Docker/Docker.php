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

        //$process = new Process('docker run opencoconut/ffmpeg -i '.storage_path('files/d5a1475c-1af0-11e7-8a60-02422098368c').' -f webm -c:v libvpx -c:a libvorbis - > '.storage_path($folder.'/'.$filename));
        $process = new Process('docker run -v=`pwd`:'.storage_path('files').' opencoconut/ffmpeg -i d5a1475c-1af0-11e7-8a60-02422098368c '.storage_path($folder.'/'.$filename));
        $process->setTimeout(1000);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $filename;

    }
}