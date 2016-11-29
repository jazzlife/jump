<?php

namespace App\Providers;

use App\Data\Data;
use App\Meta\Meta;
use App\Support\Asset;
use App\Support\Currency;
use App\Support\RequestToken;
use MenaraSolutions\Geographer\Earth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('request-token', function () {
            return new RequestToken;
        });

        $this->app->singleton('data', function () {
            return new Data;
        });

        $this->app->singleton('mailer', function ($app) {
            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
        });

        $this->app->singleton('earth', function () {
            return new Earth;
        });

        $this->app->singleton('currency', function () {
            return new Currency;
        });

        $this->app->singleton('filesystem', function ($app) {
            return $app->loadComponent('filesystems', 'Illuminate\Filesystem\FilesystemServiceProvider', 'filesystem');
        });

        $this->app->singleton('asset', function () {
            return new Asset;
        });

        $this->app->singleton('meta', function () {
            return new Meta;
        });
    }
}
