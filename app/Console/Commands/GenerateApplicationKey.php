<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateApplicationKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the application key';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key      = str_random(32);
        $env_path = base_path('.env');

        if (!is_file($env_path)) {
            return $this->warn("Environment file was not found in [{$env_path}]");
        }

        $env_conf = file_get_contents($env_path);
        $env_conf = preg_replace('/^\s*APP_KEY\s*=.*?$/m', "APP_KEY={$key}", $env_conf);

        file_put_contents($env_path, $env_conf);

        $this->info("Application key was updated [{$key}]");
    }
}