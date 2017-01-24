<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearImagesCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset:images {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears images cache of a given path';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->argument('path');

        asset()->clearImagesCache($path);

        $this->info("Images cache from [{$path}] was cleared successfully.");
    }
}
