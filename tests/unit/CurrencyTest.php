<?php

use App\Support\Facades\Currency;
use Illuminate\Support\Facades\Cache;

class CurrencyTest extends TestCase
{
    public function test_it_can_get_currency_rates()
    {
        Cache::shouldReceive('remember')->once()->andReturn('{ "USD": 1, "EUR": 2 }');

        $this->assertSame([ 'USD' => 1, 'EUR' => 2], Currency::rates());
    }

    public function test_it_can_list_all_currencies()
    {
        Cache::shouldReceive('remember')->once()->andReturn('{ "USD": 1, "EUR": 2 }');

        $this->assertSame(['USD', 'EUR'], Currency::all());
    }

    public function test_it_can_determine_if_a_currency_exists()
    {
        Cache::shouldReceive('remember')->once()->andReturn('{ "USD": 1, "EUR": 2 }');

        $this->assertTrue(Currency::exists('USD'));
        $this->assertTrue(Currency::exists('EUR'));
        $this->assertFalse(Currency::exists('MDL'));
    }

    public function test_it_can_return_symbol_of_a_currency()
    {
        $this->assertSame('$', Currency::symbol('USD'));
        $this->assertSame('€', Currency::symbol('EUR'));
        $this->assertSame('FOO', Currency::symbol('FOO'));
        $this->assertSame('MDL', Currency::symbol('MDL'));
    }

    public function test_it_can_return_template_of_a_currency()
    {
        $this->assertSame('1 $', Currency::template('AED'));
        $this->assertSame('1 $', Currency::template('FOOBAR'));
        $this->assertSame('$1', Currency::template('USD'));
        $this->assertSame('$1', Currency::template('EUR'));
        $this->assertSame('1$', Currency::template('PYG'));
    }

    public function test_it_can_return_currency_rate()
    {
        Cache::shouldReceive('remember')->once()->andReturn('{ "USD": 1, "EUR": 1.5, "CAD": 3.5 }');

        $this->assertSame((float)1, Currency::rate('USD'));
        $this->assertSame((float)1.5, Currency::rate('EUR'));
        $this->assertSame((float)3.5, Currency::rate('CAD'));
        $this->assertSame((float)1, Currency::rate('MDL'));

        $this->assertSame((float)1, Currency::rate('EUR', 'EUR'));
        $this->assertSame((float)1 / 1.5 * 1, Currency::rate('USD', 'EUR'));
        $this->assertSame((float)1 / 1.5 * 3.5, Currency::rate('CAD', 'EUR'));
    }

    public function test_it_can_make_a_value_pretty()
    {
        $this->assertSame((float)12.34, Currency::pretty(12.341234));
        $this->assertSame((float)12.34, Currency::pretty(12.3412352, false));
        $this->assertSame((float)23.45, Currency::pretty(23.4523312));
        $this->assertSame((float)34.99, Currency::pretty(34.345123, true));
        $this->assertSame((float)34.99, Currency::pretty(34.00, true));
    }

    public function test_it_can_return_a_value_in_a_given_currency()
    {
        Cache::shouldReceive('remember')->once()->andReturn('{ "USD": 1, "EUR": 1.5, "CAD": 3.5 }');

        $this->assertSame((float)10, Currency::value(10, 'USD'));
        $this->assertSame((float)123, Currency::value(123, 'USD'));
        $this->assertSame((float)123 * 1.5, Currency::value(123, 'EUR'));
        $this->assertSame((float)235 * 1.5, Currency::value(235, 'EUR'));
        $this->assertSame((float)123 * 3.5, Currency::value(123, 'CAD'));
        $this->assertSame((float)235 * 3.5, Currency::value(235, 'CAD'));
        $this->assertSame((float)123, Currency::value(123, 'MDL'));
        $this->assertSame((float)235, Currency::value(235, 'MDL'));
    }

    public function test_it_can_format_a_value_in_a_given_currency()
    {
        Cache::shouldReceive('remember')->once()->andReturn('{ "USD": 1, "EUR": 1.5, "CAD": 3.5 }');

        $this->assertSame('$10.00', Currency::format(10, 'USD'));
        $this->assertSame('$123.00', Currency::format(123, 'USD'));
        $this->assertSame('€184.50', Currency::format(123, 'EUR'));
        $this->assertSame('€352.50', Currency::format(235, 'EUR'));
        $this->assertSame('CA$430.50', Currency::format(123, 'CAD'));
        $this->assertSame('CA$822.50', Currency::format(235, 'CAD'));
        $this->assertSame('123.00 MDL', Currency::format(123, 'MDL'));
        $this->assertSame('235.00 MDL', Currency::format(235, 'MDL'));
        $this->assertSame('10,000.99 MDL', Currency::format(10000, 'MDL', true));
        $this->assertSame('100,000,000.99 MDL', Currency::format(100000000, 'MDL', true));
    }
}