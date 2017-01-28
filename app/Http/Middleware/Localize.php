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

        } else {

            $prefered_locale = current(array_intersect($this->getPreferedLocales(), locales()));

            if ($prefered_locale) {

                locale($prefered_locale);
            }
        }

        return $next($request);
    }

    /**
     * Returns client's prefered locales.
     *
     * @return array
     */
    public function getPreferedLocales():array
    {
        if (!preg_match_all(
                '/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
                substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 200),
                $matches
            )) {
            return [];
        }

        return $matches[1];
    }
}