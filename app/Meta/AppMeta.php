<?php

namespace App\Meta;

class AppMeta extends Meta
{
    /**
     * Initializes default meta fields for the application.
     *
     * @return void
     */
    public function init()
    {
        $this->type  = 'website';
        $this->url   = app('request')->fullUrl();
        $this->token = app('request-token')->get();

        //
    }
}