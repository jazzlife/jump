<?php

namespace App\Http\Middleware;

use Closure;

class Localize
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
        if ($request->has('hl') and is_string($request->input('hl'))) {

            $locale  = substr($request->input('hl'), 0, 20);

            if (in_array($locale, locales())) {

                locale($locale);
            }
        }

        return $next($request);
    }
}