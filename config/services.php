<?php

return [

    /**
     * Third Party Mail Service Configuration.
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    /**
     * Up-To-Date Currency Exchange Rates Service Configuration.
     */

    'openexchangerates' => [
        'app_id' => env('OPENEXCHANGERATES_APP_ID'),
    ],

];