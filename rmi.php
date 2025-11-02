<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class rmi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rmi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unwanted images from assets path';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sqlFileContent = file_get_contents(base_path('DB/escrova.sql'));

        $allImages = File::allFiles(public_path('global/uploads'));

        foreach ($allImages as $key => $file) {
            $fileName = basename($file);
            $mimeType = File::mimeType($file);

            if (!str_contains($sqlFileContent, $fileName) && str_contains($mimeType, 'image')) {
                File::delete(($file));
                $this->info("Deleted: $fileName");
            }
        }
    }
}

