<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Create a new page instance.
     */
    public function __construct()
    {
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

    /**
     * Generic error page.
     *
     * @return \Illuminate\Http\Response
     */
    public function error()
    {
        $payload = json_decode(decrypt(app('request')->input('p')), true);

        return response($payload['message'] ?? '', $payload['code'] ?? 400);
    }

    /**
     * Page for unsuported browsers.
     *
     * @return \Illuminate\Http\Response
     */
    public function browser()
    {
        $url = url_to('/');

        return response("To view this website please update your browser to the latest version. <br><a href='{$url}'>Try again</a>", 403);
    }
}