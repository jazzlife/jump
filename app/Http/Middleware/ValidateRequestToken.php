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
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!RequestToken::validate($token = $request->header('token'))) {

            return response('Bad Request.', 400);
        }

        RequestToken::set($token);

        return $next($request);
    }
}