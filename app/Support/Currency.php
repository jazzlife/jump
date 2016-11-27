<?php

namespace App\Support;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Currency
{
    /** @var array */
    protected $rates;

    /** @var array */
    protected $currencies;

    /** @var array */
    protected $formats;

    /** @var string */
    protected $cacheKey = 'currency.rates';

    /**
     * Retreives up-to-date currency rates.
     *
     * @return array
     */
    public function fresh():array
    {
        $url = 'https://openexchangerates.org/api/latest.json?app_id=' . config('services.openexchangerates.app_id');
        $response = (new Client([ 'http_errors' => false ]))->get($url);
        $response = json_decode((string)$response->getBody(), true);

        if (!$response or !isset($response['rates'])) {
            return [];
        }

        return (array)$response['rates'];
    }

    /**
     * Returns cached currency rates.
     *
     * @return array
     */
    public function rates():array
    {
        if ($this->rates) {
            return $this->rates;
        }

        return $this->rates = (array)json_decode(Cache::remember($this->cacheKey, 360, function () {
            return json_encode($this->fresh());
        }), true);
    }

    /**
     * Returns a list of available currencies.
     *
     * @return array
     */
    public function all():array
    {
        if ($this->currencies) {
            return $this->currencies;
        }

        return $this->currencies = array_keys($this->rates());
    }

    /**
     * Returns money formats for all currencies.
     *
     * @return array
     */
    public function formats():array
    {
        if ($this->formats) {
            return $this->formats;
        }

        return $this->formats = (array)json_decode(
            file_get_contents(base_path('resources/data/currency-format.json')),
            true
        );
    }

    /**
     * Removes cached version of currency rates.
     *
     * @return void
     */
    public function forget()
    {
        Cache::forget($this->cacheKey);
    }

    /**
     * Determines if a currency exists.
     *
     * @param  string $currency
     *
     * @return bool
     */
    public function exists(string $currency):bool
    {
        return isset($this->rates()[$currency]);
    }

    /**
     * Returns the symbol of a given currency.
     *
     * @param  string $currency
     *
     * @return string
     */
    public function symbol(string $currency):string
    {
        $formats = $this->formats();

        if (!isset($formats[$currency])) {
            return $currency;
        }

        $format = $formats[$currency];

        if (isset($format['uniqSymbol']['grapheme'])) {
            return $format['uniqSymbol']['grapheme'];
        }

        if (isset($format['symbol']['grapheme'])) {
            return $format['symbol']['grapheme'];
        }

        return $currency;
    }

    /**
     * Returns representation template of a given currency.
     *
     * @param  string $currency
     *
     * @return string
     */
    public function template(string $currency):string
    {
        $formats = $this->formats();

        if (!isset($formats[$currency])) {
            return '1 $';
        }

        $format = $formats[$currency];

        if (isset($format['uniqSymbol']['template'])) {
            return $format['uniqSymbol']['template'];
        }

        if (isset($format['symbol']['template'])) {
            return $format['symbol']['template'];
        }

        return '1 $';
    }

    /**
     * Returns cached rate of a given currency.
     *
     * @param  string $currency
     * @param  string $base
     *
     * @return float
     */
    public function rate(string $currency, string $base = 'USD'):float
    {
        $rates = $this->rates();

        if (!isset($rates[$currency])) {
            return (float)1;
        }

        $rate      = (float)$rates[$currency];
        $base_rate = (float)($rates[$base] ?? 1);

        if ($base_rate == 0) {
            return (float)1;
        }

        if ($base_rate == 1) {
            return (float)$rate;
        }

        return (float)(1 / $base_rate * $rate);
    }

    /**
     * Makes a value to look prettier.
     *
     * @param  float  $value
     * @param  bool   $pretty
     *
     * @return float
     */
    public function pretty(float $value, bool $pretty = false):float
    {
        return !$pretty ? round($value, 2) : floor($value) + .99;
    }

    /**
     * Returns a value in a given currency.
     *
     * @param  float  $value
     * @param  string $currency
     * @param  string $base
     * @param  bool   $pretty
     *
     * @return float
     */
    public function value($value, $currency, $base = 'USD', $pretty = false)
    {
        return $this->pretty((float)$value * $this->rate($currency, $base), $pretty);
    }

    /**
     * Formats a value in a given currency.
     *
     * @param  float  $value
     * @param  string $currency
     * @param  string $base
     * @param  bool   $pretty
     *
     * @return string
     */
    public function format($value, $currency, $base = 'USD', $pretty = false):string
    {
        return strtr($this->template($currency), [
            '1' => number_format($this->value($value, $currency, $base, $pretty), 2),
            '$' => $this->symbol($currency)
        ]);
    }
}