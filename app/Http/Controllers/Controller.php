<?php

namespace App\Http\Controllers;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Determines if current request was made by a web crawler.
     *
     * @param  string $custom_user_agent
     *
     * @return bool
     */
    protected function isCrawler(string $custom_user_agent = ''):bool
    {
        return (new CrawlerDetect)->isCrawler($custom_user_agent);
    }

    /**
     * Renders a page of the application.
     *
     * @param  string $template
     * @param  array  $data
     *
     * @return \Illuminate\Http\Response
     */
    protected function render($template = 'app', $data = [])
    {
        if (is_array($template)) {

            $data     = $template;
            $template = 'app';
        }

        return view($template, $data);
    }
}
