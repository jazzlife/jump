<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAssetsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Assets Cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        asset()->flush();

        $this->info('Assets cache was cleared successfully.');
    }
}
