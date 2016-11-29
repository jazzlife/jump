<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Create a new page instance.
     */
    public function __construct()
    {
        meta()->token = app('request-token')->get();

        meta()->make();
        data()->make();
    }

    /**
     * Application's home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->render();
    }
}