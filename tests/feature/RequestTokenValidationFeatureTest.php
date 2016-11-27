<?php

use Illuminate\Support\Facades\Request;

class RequestTokenValidationFeatureTest extends TestCase
{
    public function create_route($middleware = 'token')
    {
        $_SERVER['REMOTE_ADDR'] = '123.456.789.0';

        $path = '/api/application_test_' . str_random(12);

        $this->app->get($path, ['middleware' => $middleware, function () {
            return 'OK.';
        }]);

        return $path;
    }

    public function test_it_allows_regular_requests()
    {
        $path = $this->create_route();

        $this->get($path);

        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertSame('OK.', $this->response->getContent());

        $this->get($path, [
            'Token' => str_random(12)
        ]);

        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertSame('OK.', $this->response->getContent());
    }

    public function test_it_denies_regular_requests_in_strict_mode()
    {
        $path = $this->create_route('token:strict');

        $this->get($path);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Bad Request.', $this->response->getContent());
    }

    public function test_it_denies_ajax_requests_with_invalid_tokens()
    {
        $path = $this->create_route();

        $this->get($path, [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Invalid Request Token.', $this->response->getContent());

        $this->get($path, [
            'X-Requested-With' => 'XMLHttpRequest',
            'Token' => str_random(12)
        ]);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Invalid Request Token.', $this->response->getContent());
    }

    public function test_it_denies_ajax_requests_with_expired_tokens()
    {
        $path = $this->create_route();
        $token = $this->app['request-token']->generate(0);

        sleep(1);

        $this->get($path, [
            'X-Requested-With' => 'XMLHttpRequest',
            'Token' => $token
        ]);

        $this->assertSame(400, $this->response->getStatusCode());
        $this->assertSame('Invalid Request Token.', $this->response->getContent());
    }

    public function test_it_allows_ajax_requests_with_valid_tokens()
    {
        $path = $this->create_route();

        $this->get($path, [
            'X-Requested-With' => 'XMLHttpRequest',
            'Token' => $this->app['request-token']->generate()
        ]);

        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertSame('OK.', $this->response->getContent());
    }
}