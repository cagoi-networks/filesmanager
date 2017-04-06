<?php

namespace App\Console\Commands;

use App\Acme\Video\VideoConversionFacade;
use App\Models\File;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Illuminate\Console\Command;

class VideoConversion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filesmanager:conversion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Background video conversion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $list = ['webm' => null];

        $object = new VideoConversionFacade();

        $rows = File::getVideoFiles();

        if($rows->isEmpty())
            return false;

        foreach ($rows as $row)
        {
            $file = Flysystem::read($row->getKey());

            foreach ($list as $operation => $arguments)
            {
                if(!method_exists($object, $operation) )
                    abort(404, 'Method not found');

                $file = $object->$operation($file);

                $row->saveResult($file, [$operation => $arguments], 'video');
            }
        }
    }
}
