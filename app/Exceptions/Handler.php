<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (app()->environment('production')) {

            $message = '';
            $code    = 400;

            if ($e instanceof HttpException) {
                $code    = $e->getStatusCode();
                $message = $e->getMessage();
            }

            if ($e instanceof AuthorizationException) {
                $code = 401;
            }

            if ($e instanceof ValidationException) {
                $code = 422;
            }

            if ($e instanceof ModelNotFoundException) {
                $code = 404;
            }

            if (empty($message)) {

                switch ($code) {
                    case 401: $message = 'Unauthorized.'; break;
                    case 403: $message = 'Access denied.'; break;
                    case 404: $message = 'Page not found.'; break;
                    case 405: $message = 'Not allowed.'; break;
                    case 500: $message = 'Server not available.'; break;
                    default: $message = 'Bad Request.';
                }
            }

            return redirect('/error?p=' . encrypt(json_encode([ 'code' => $code, 'message' => $message ])));
        }

        return parent::render($request, $e);
    }
}
