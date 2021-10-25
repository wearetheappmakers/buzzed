<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class CreateDirectoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:create-directory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Directory';

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
        $storagePath = storage_path("/app/public/uploads/");

        $image_type = config('custom_setting.image_optimize_thumb_folder');
        $directoriesPath[] = $storagePath.'banner/';
        $directoriesPath[] = $storagePath.'page/';
        $directoriesPath[] = $storagePath.'product/';
        $directoriesPath[] = $storagePath.'category/';
        foreach($image_type as $image) {
            $directoriesPath[] = $storagePath.'banner/'.$image; 
            $directoriesPath[] = $storagePath.'page/'.$image;
            $directoriesPath[] = $storagePath.'product/'.$image;
            $directoriesPath[] = $storagePath.'category/'.$image;
        }
        foreach ($directoriesPath as $key => $value) {
            if(!File::exists($value)) {
                $oldmask = umask(0);
                File::makeDirectory($value, 0777, true, true);
                umask($oldmask);
            } 
        }
    }
}
