<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PushAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset:push {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploads assets to the S3 cloud storage';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $type = $this->argument('type');

        if ($type !== 'all') {

            asset()->push($type);
        } else {

            asset()->push('images');
            asset()->push('styles');
            asset()->push('scripts');
        }

        $this->info("All assets (if any) of type [{$this->argument('type')}] were uploaded to S3.");
    }
}
