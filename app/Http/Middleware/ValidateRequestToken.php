<?php

namespace App\Http\Middleware;

use Closure;
use App\Support\Facades\RequestToken;

class ValidateRequestToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $strict
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $strict = null)
    {
        if ($strict === 'strict') {

            if (!$request->ajax()) {

                return response('Bad Request.', 400);
            }
        }

        if ($request->ajax()) {

            if (!RequestToken::validate($request->header('token'))) {
                return response('Invalid Request Token.', 400);
            }

            RequestToken::set($request->header('token'));
        }

        return $next($request);
    }
}