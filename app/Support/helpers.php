<?php

/**
 * Determines the "real" IP address of the client.
 *
 * @return string
 */
function ip()
{
    return \SumanIon\CloudFlare::ip();
}

/**
 * Determines current country code of the client.
 * If first argument is passed, returns country information.
 *
 * @param  string|bool|null $code
 *
 * @return string|array
 */
function country($code = null)
{
    if (!$code) {
        return \SumanIon\CloudFlare::country() ?: 'US';
    }

    if (true === $code) {
        return country(\SumanIon\CloudFlare::country() ?: 'US');
    }

    try {
        return app('earth')->findOneByCode($code);
    } catch (\Exception $ex) {
        return null;
    }
}

/**
 * Returns a list of all countries.
 *
 * @return \MenaraSolutions\Geographer\Collections\MemberCollection
 */
function countries()
{
    return app('earth')->getCountries();
}

/**
 * Returns / Updates current locale.
 *
 * @param  string|null $locale
 *
 * @return string|null
 */
function locale(string $locale = null)
{
    if (!$locale) {
        return app('translator')->getLocale();
    }

    app('translator')->setLocale($locale);
}

/**
 * Lists available locales.
 *
 * @return array
 */
function locales():array
{
    static $locales;

    if (!$locales) {
        $locales = explode(',', config('app.locales'));
        $locales = collect($locales)->map(function ($locale) {
            return trim($locale);
        })->filter(function ($locale) {
            return !empty($locale);
        })->all();
    }

    return array_unique($locales);
}

/**
 * Translates the given message based on a count.
 *
 * @param  string                $id
 * @param  int|array|\Countable  $number
 * @param  array                 $parameters
 * @param  string                $domain
 * @param  string                $locale
 *
 * @return string
 */
function trans_choice($id, $number, array $parameters = [], $domain = 'messages', $locale = null)
{
    return app('translator')->transChoice($id, $number, $parameters, $domain, $locale);
}

/**
 * Appends locale to an url.
 *
 * @param  string $url
 * @param  string $locale
 *
 * @return string
 */
function url_add_locale(string $url, string $locale):string
{
    if (strpos($url, '?') !== false) {
        $url .= '&';
    } else {
        $url .= '?';
    }

    return "{$url}hl={$locale}";
}

/**
 * Generates a localized URL.
 *
 * @param  mixed $arguments
 *
 * @return string
 */
function url_to(...$arguments):string
{
    if (count(locales()) < 2) {
        return call_user_func_array('url', $arguments);
    }

    return url_add_locale(call_user_func_array('url', $arguments), locale());
}

/**
 * Returns data instance.
 *
 * @param  string|null    $child
 *
 * @return \App\Data\Data
 */
function data(string $child = null)
{
    if ($child) {
        return app('data')->make($child);
    }

    return app('data');
}

/**
 * Returns Currency instance.
 *
 * @return \App\Support\Currency
 */
function currency()
{
    return app('currency');
}

/**
 * Returns Filesystem instance.
 *
 * @return \Illuminate\Filesystem\FilesystemManager
 */
function storage()
{
    return app('filesystem');
}

/**
 * Returns Asset instance.
 *
 * @return \App\Support\Asset
 */
function asset()
{
    return app('asset');
}

/**
 * Returns Meta instance.
 *
 * @param  string|null       $child
 *
 * @return \App\Support\Meta
 */
function meta(string $child = null)
{
    if ($child) {
        return app('meta')->make($child);
    }

    return app('meta');
}

/**
 * Creates URLs to CDNJS depending on current environment.
 *
 * @param  string $url
 *
 * @return string
 */
function cdnjs(string $url):string
{
    $url = preg_replace('/\.min\.(js|css)$/i', '.$1', $url);

    if (!app()->environment('production')) {
        return $url;
    }

    return preg_replace('/\.(js|css)$/i', '.min.$1', $url);
}