<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
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
