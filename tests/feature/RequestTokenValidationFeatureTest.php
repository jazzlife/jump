<?php

use Illuminate\Support\Facades\Request;

class RequestTokenValidationFeatureTest extends TestCase
{
    public function create_route($middleware = null)
    {
        $_SERVER['REMOTE_ADDR'] = '123.456.789.0';

        $path     = '/api/application_test_' . str_random(12);
        $response = function () { return 'OK.'; };

        if ($middleware) {

            $this->app->get($path, [ 'middleware' => $middleware, $response ]);
        } else {

            $this->app->get($path, $response);
        }

        return $path;
    }

    public function test_it_allows_regular_requests_to_web_routes()
    {
        $path = $this->create_route();

        $this->get($path);

        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertSame('OK.', $this->response->getContent());
    }

    public function test_it_denies_regular_requests_to_api_routes()
    {
        $path = $this->create_route('token');

        $this->get($path);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Bad Request.', $this->response->getContent());
    }

    public function test_it_denies_api_requests_with_invalid_tokens()
    {
        $path = $this->create_route('token');

        $this->get($path);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Bad Request.', $this->response->getContent());

        $this->get($path, [ 'Token' => str_random(12) ]);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Bad Request.', $this->response->getContent());
    }

    public function test_it_denies_api_requests_with_expired_tokens()
    {
        $path = $this->create_route('token');
        $token = $this->app['request-token']->generate(0);

        sleep(1);

        $this->get($path, [ 'Token' => $token ]);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Bad Request.', $this->response->getContent());
    }

    public function test_it_allows_api_requests_with_valid_tokens()
    {
        $path = $this->create_route('token');

        $this->get($path, [
            'Token' => $this->app['request-token']->generate()
        ]);

        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertSame('OK.', $this->response->getContent());
    }
}