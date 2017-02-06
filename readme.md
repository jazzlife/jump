
<p align="center">
    <img src="./resources/jump.png" width="140" height="197">
</p>

<br>

**Jump** is an opinionated setup of [Lumen](https://lumen.laravel.com/) micro-framework, preconfigured / modified to allow Developers to create Single Page Applications a lot faster using modern technologies.

<br>

### What's in the box?

---

- [**Lumen** 5.3.2](#lumen) 
- [**VueJS** 2.1.10](#vuejs)
- [**Vuex** 2.1.1](#vuex)
- [**Vue-Router** 2.2.0](#vue-router)
- [Built-in MongoDB Support](#mongodb)
- Tools & Libraries
    - PHP
        - [Tinker](#tinker)
        - [Redis](#redis)
        - [GuzzleHTTP](#guzzlehttp)
        - [Geographer](#geographer)
    - NPM
        - [Pug](#pug)    
        - [Stylus](#stylus)
        - [Rupture](#rupture)
        - [Lost Grids](#lost-grids)
        - [Lodash](#lodash)
    - Browser
        - [Modernizr](#modernizr)
        - [Babel ES6 Polyfills](#babel-es6-polyfills)
        - [String-Format](#string-format)
        - [Axios](#axios)
        - [Store](#store)
        - [FastClick](#fastclick)
        - [NormalizeCSS](#normalizecss)
- Custom Classes & Features
    - [Sentry Error Reporting](#sentry-error-reporting)
    - [Multiple Languages](#multiple-languages)
    - [Detect Crawlers](#detect-crawlers)
    - [Mail Support](#mail-support)
    - [RequestToken Manager](#requesttoken-manager)
    - [Request Throttling](#request-throttling)
    - [Data Manager](#data-manager)
    - [Meta Manager](#meta-manager)
    - [Asset Manager](#asset-manager)
    - [Currency Manager](#currency-manager)
    - [Beanstalkd Queues](#beanstalkd-queues)

> Jump may also include some additional supporting libraries and packages which are not included in the list.

<br>

### Installation

---

> Jump requires PHP 7.0 or later.

```bash
# First, download source files.
composer create-project sumanion/jump
cd jump

# Then, install node dependencies.
# Note: You should have node & npm installed.
npm install

# Finally, compile assets.
# Note: You should have gulp package installed globally. (npm install -g gulp)
gulp
```

<br><br>

### Components

---

<br>

#### Lumen

Jump uses Lumen micro-framework on backend, because it is blazing fast and easy to use.

- [Lumen Docs](https://lumen.laravel.com/docs/5.3)

<br>

#### VueJS

To build powerful client interfaces Jump uses *the most progressive* JavaScript framework - **VueJS**.

- [VueJS Docs](http://vuejs.org/v2/guide/)

###### Usage:

By default, Jump loads `/resources/assets/js/layouts/app.vue` component as the main template of the aplication in `/resources/assets/js/app.js`. You can edit the layout to match your needs or create a new layout.

<br>

#### Vuex

Vuex is a state management pattern + library for VueJS applications. It serves as a centralized store for all the components in an application, with rules ensuring that the state can only be mutated in a predictable fashion.

- [Vuex Docs](https://vuex.vuejs.org/)

###### Usage:

Vuex is initialized in `/resources/assets/js/store/index.js` file and contains some parts: `actions`, `getters`, `mutations` and `state` which are self-descriptive if you read docs. 

> New modules can be created in the `/resources/assets/js/store/modules/` directory.

> It is recommended to store all mutation types in the `/resources/assets/js/store/mutation-types.js` file.

<br>

#### Vue-Router

A powerful router for VueJS SPAs.

- [Vue-Router Docs](https://router.vuejs.org/)

###### Usage:

Vue-Router is initialized in `/resources/assets/js/router/index.js` file and loads all routes from `/resources/assets/js/router/routes.js`.

<br>

#### MongoDB

*MongoDB is an open source database that uses a document-oriented data model. Instead of using tables and rows as in relational databases, MongoDB is built on an architecture of collections and documents.*

Jump uses MongoDB by default, as the main database driver (instead of MySQL), because of it's power, flexibility, scalability and performance.

- [MongoDB Official Website](https://www.mongodb.com/)
- [Install MongoDB on Dev Machine](https://docs.mongodb.com/manual/installation/)
- [Install MongoDB PHP Driver on Dev Machine](http://php.net/manual/en/mongodb.setup.php)
- [All-In-One installer for Homestead](https://github.com/zakhttp/Mongostead7)
- [Use MongoDB with Eloquent](https://github.com/jenssegers/laravel-mongodb)
- [Cross-Platform MongoDB Manager](https://robomongo.org/)

> *laravel-mongo* package is already installed and configured.

###### Usage:

To use MongoDB in your Models just extend them with `\App\Model`, then use the MongoDB Models just like regular Eloquent Models. 
[Read more about limitations and unique features.](https://github.com/jenssegers/laravel-mongodb)

```php
<?php

namespace App;

class Product extends Model
{
    
}

```

<br>

#### Tinker

Tinker is an interactive shell for Lumen micro-framework.

- [More Details on Tinker](https://github.com/vluzrmos/lumen-tinker)

###### Usage:

```bash
# To start interactive shell run the following command from your project's directory.
php artisan tinker
```

<br>

#### Redis

Jump uses Redis as the default cache driver, because of it's amazing speed.

> You should have Redis installed on your machine. (Homestead have it installed by default)

- [Redis Official Website](https://redis.io/)

*You can use Redis facade to execute Redis commands.*
[*More details*](https://laravel.com/docs/5.3/redis)

> *predis/predis* package is already installed.

<br>

#### GuzzleHTTP

Guzzle is a PHP HTTP client that makes it easy to send HTTP requests and trivial to integrate with web services.

- [GuzzleHTTP Docs](http://docs.guzzlephp.org/en/latest/)

<br>

#### Geographer

Geographer is a PHP library that knows how any country, state or city is called in any language.

- [Geographer Docs](https://geographer.su/documentation/php/)

<br>

#### Pug

Pug is a template language which is used in Vue components to create templates faster.

- [Pug Docs](https://pugjs.org/api/getting-started.html)

###### Usage:

*/resources/assets/js/components/example-component.vue*

```html
<template lang="pug">
    <!-- / pug code / -->
</template>
```

<br>

#### Stylus

Stylus is a revolutionary new language, providing an efficient, dynamic, and expressive way to generate CSS. Jump uses Stylus in Vue compoenents and to create main style of the application.

- [Stylus Docs](http://stylus-lang.com/)

###### Usage:

*/resources/assets/js/components/example-component.vue*

```html
<style lang="stylus">
    /* stylus code */
</style>
```

<br>

#### Rupture

Rupture is a utility for working with media queries in stylus. It takes advantage of stylus' new block mixins to provide useful helpers that make breakpoints much more clear to read and simple to code. Rupture is based loosely on breakpoint-slicer, a sass plugin with similar functionality.

Jump loads Rupture in Vue compoenents styled with Stylus and in Stylus files compiled by the application.

- [Rupture Docs](http://jescalan.github.io/rupture/)

<br>

#### Lost Grids

Lost Grids is a powerful grid system built in PostCSS that works with any preprocessor and even vanilla CSS.

Jump loads Lost Grids in Vue components styled with Stylus and in Stylus files compiled by the application.

- [Lost Grids Docs](http://lostgrid.org/docs.html)

<br>

#### Lodash

Lodash is A modern JavaScript utility library delivering modularity, performance & extras.

- [Lodash Docs](https://lodash.com/docs/4.17.4)

###### Usage:

```javascript
let random = require('lodash/random');

console.log(random(0, 10)); // 7
```

<br>

#### Modernizr

Modernizr is a JavaScript library that detects which HTML5 and CSS3 features your visitor's browser supports.

- [Modernizr Docs](https://modernizr.com/docs)

###### Usage:

```javascript
if (Modernizr.flexbox) {
    // Browser supports flexbox.
} else {
    // Browser doesn't support flexbox.
}
```

<br>

#### Babel ES6 Polyfills

Babel ES6 Polyfills will emulate a full ES2015 environment for browsers which doesn't support ES2015 yet.

- [More Details on Babel ES6 Polyfills](https://babeljs.io/docs/usage/polyfill/)

<br>

#### String Format

A small JavaScript library used to format strings.

- [String Format Docs](https://github.com/davidchambers/string-format)

<br>

#### Axios

Axios is a Promise based HTTP client used to make HTTP requests.

- [Axios Docs](https://github.com/mzabriskie/axios)

<br>

#### Store

Store.js is a localStorage wrapper for all browsers without using cookies or flash.

- [Store Docs](https://github.com/marcuswestin/store.js)

<br>

#### FastClick

FastClick is a polyfill to remove click delays on browsers with touch UIs.

- [FastClick Docs](https://github.com/ftlabs/fastclick)

<br>

#### NormalizeCSS

NormalizeCSS makes browsers render all elements more consistently and in line with modern standards.

- [More Details about NormalizeCSS](http://nicolasgallagher.com/about-normalize-css/)

<br>

#### Sentry Error Reporting

Sentry's real-time error tracking gives you insight into production deployments and information to reproduce and fix crashes.

###### Usage:

1. Register on the [Sentry website](https://sentry.io/).
2. Create a **New Project**.
3. On the **"Configure your application"** page click **"Get your DSN"**.
4. Copy **URL** from **DSN** to `SENTRY_DSN` constant in the `.env` file.
5. Copy **URL** from **Public DSN** to `SENTRY_PUBLIC_DNS` constant in the `.env` file.
6. Now, all `PHP` and `JavaScript` errors will be reported to your Sentry dashboard.

<br>

#### Multiple Languages

Lumen, by default, supports multiple languages and in Jump we enhanced this feature a bit, and now you can change the language from the URL.

> If no language is passed in the query string (`hl` parameter), the preferred language will be matched automatically.

###### Usage:

1. Add a comma separated list of languages available in your application to the `APP_LOCALES` constant to the `.env` file. (ex: `APP_LOCALES=en,fr,es,ru`)
2. Set the default language to the `APP_LOCALE` constant in the `.env` file.
3. Set the fallback language to the `APP_FALLBACK_LOCALE` constant in the `.env` file.
4. Now you can change language from the URL like this: `http://app.dev/?hl=fr`

<br>

#### Detect Crawlers

A big problem of SPAs is the SEO, and in Jump, to keep things as simple as possible, without any server-side rendering or things like that, we just detect crawlers and search engines and respond accordingly.

When a crawler or a search engine is matched you can print just a basic page with all information related to that page, else load the entire application.

- [Crawler Detect Docs](https://github.com/JayBizzle/Crawler-Detect)

###### Usage:

```php
// Every Controller has a method to detect crawlers and search engines.
// It returns true / false.
$this->isCrawler();
```

<br>

#### Mail Support

Mail support was removed from Lumen, but in Jump we bring in back. Usage is the same as in Laravel.

- [Laravel Mail Docs](https://laravel.com/docs/5.3/mail)

> In Jump, default mail driver is set to *mailgun*

<br>

#### RequestToken Manager

In Jump, we divided routes in two categories: `web` and `api` routes.

The `web` routes are located at `/routes/web.php` and are regular routes which can be visited by users from the browser.

The `api` routes are located at `/routes/api.php` and all requests to these routes should be signed with a *Request Token*. Requests to these routes should be made with `XMLHttpRequest` from the client side to perform any operations on the server side.

RequestToken Manager is already integrated and configured in Jump and every request made with *Axios* is signed with the right Token.

###### API:

```php
// Generates a new Token which is valid for 10 seconds.
app('request-token')->generate(10);

// Sets a new Token.
app('request-token')->set('NEW_TOKEN');

// Updates the Token.
app('request-token')->update();

// Returns current Token.
app('request-token')->get();

// Validates a Token.
app('request-token')->validate('TOKEN');
```

> See tests for more details.

<br>

#### Request Throttling

Jump allows only `60` Ajax request per minute from an IP address and `120` regular HTTP requests per minute from an IP address.

> These limits can me modified in `/bootstrap/app.php`


<br>

#### Data Manager

Data Manager is a class which contains a store of key-value pairs with data used by the Vue Components and the translation of the Application.

> Data Manager sends it's values to Vuex Store.

###### Usage:

Default Data Manager of the Application is the `\App\Data\AppData` class.

To add new values to the `store` just edit `store` method of the class:

```php
public function store() 
{
    return [
        'foo' => 'foobar'
    ];
}
```

Next, you can access passed values in Vue Components like this:

```javascript
this.$store.state.foo; // foobar
```

To add new values to the `translation` just edit `translation` method of the class:

```php
public function translation()
{
    return [
        'greeting' => 'Hello!'
    ];
}
```

Finally, you can access translation in Vue Components like this:

```javascript
this.$store.state.trans.greeting; // Hello!
```

> You can create as many Data Managers as you want, just make sure you extend `\App\Data\Data` class and create new Data Managers in the `/app/Data/` directory.


###### API:

```php
// Load a Data Manager.
data()->make(); // Default: 'AppData'
data()->make('MyData');

// Return all store values from all loaded Data Managers.
data()->toArray('store');

// Add a new store value to the Data Manager.
data()->set('store', 'foo', 'bar');

// Remove a store value from the Data Manager.
data()->remove('store', 'foo');

// Add a new translated value to the Data Manager.
data()->set('translation', 'foo', 'bar');

// Remove a translated value from the Data Manager.
data()->remove('translation', 'foo');

// Return all translated values from all loaded Data Managers.
data()->toArray('translation');
```

<br>

#### Meta Manager

Meta Manager is a class wich helps to add meta tags to the Application a lot faster.

###### Usage:

Default Meta Manager of the Application is the `\App\Meta\AppMeta` class.

To add default meta fields just edit the `init` method of the class:

```php
public function init()
{
    // Add: <meta property="og:type" content="website">
    $this->type = 'website'; 

    // Add: <title>Hello</title>
    $this->title = 'Hello';

    // ... //
}
```

> You can create as many Meta Managers as you want, just make sure you extend `\App\Meta\Meta` class and create new Meta Managers in the `/app/Meta/` directory.


###### API:

```php
// Load a Meta Manager.
meta()->make(); // Default: 'AppMeta'
meta()->make('MyMeta');

// Add: <meta name="foo" content="bar">
meta()->foo = 'bar';
meta()->set('foo', 'bar', 'meta');

// Return all meta fields from all loaded Meta Managers.
meta()->fields();

// Convert meta fields to HTML tags.
meta()->toHtml();
```

<br>

#### Asset Manager

Asset Manager is a class which creates URLs with versions to the local assets, and creates CSS representation of all image assets.

###### URLs:

Let's say we have a CSS file in `/public/css/bundle.css`, obviously we can add the URL manually `<link rel="stylesheet" href="/css/bundle.css">`, but if the file is cached in client's browser and we modify the CSS, the client won't see any changes until cache expires.

You can add versions manually (like: `/css/bundle.css?v=1`), but, in Jump, to make this process faster and easier, we created a dedicated method which will create unique versions for every asset and it will change the version if you modify the asset:

*__Example:__*

```php
// Creates unique URLs to every version of an asset.
// Returns something like: /css/bundle.css?v=6eccfa82a75faacee3a5044c9215dedebd1f481a
asset()->url('/css/bundle.css');
```

###### Images:

Let's say we have an image in `/public/images/my-image.jpg` and we want to use it in our components. This is trivial, but when we have retina versions of images, we have to use mixins or to create media queries ourselves, and if an image is used in multiple components we have to move it outside to prevend duplication, and what if we want to use a CDN? Then we will have to update all URLs in all components.

In Jump, we decided to make the entire process a lot faster, and much easier: The Asset Manager will read all images in a public directory (default: `/public/images/`) and will create their CSS representation and add it to the page. It also adds media queries automatically for retina images.

*__Example:__*

Let's use our example image again: `/public/images/my-image.jpg` with dimensions of `200x100 px`. The Asset Manager will read the image and will create it's CSS representation like this: 

```css
.img--my-image {
    background-image: url(/public/images/my-image.jpg);
    background-size: 200px 100px;
    background-position: 0 0;
    background-repeat: no-repeat;
}
```

> The class name `img--my-image` is created from the basename of the image, using `str_slug()` helper. `.img--` is the default prefix.

Then, it will add the CSS in `<head>` section of the page, in `/resources/views/app.blade.php`.

Finally, to use the image just use it's class in the desired tag of our component:

```html
<template>
    <div>
        <!-- /.../ -->
        <div class="img--my-image"></div>
        <!-- /.../ -->
    </div>
</template>
```

> Retina versions of images are added automatically, just make sure their name is the same as for non-retina version and they end in `@2x` (example: `/public/images/my-image@2x.jpg`)

*__Performance:__*

Reading all images in a directory and determining their dimensions can be slow in some cases, and to prevent high resource usage and the slow execution, the CSS representation of images is forever cached using default cache driver.

> If you update images in a directory where Asset Manager is used, make sure you clear the cache or you won't see changes. Command to clear entire asset cache is `php artisan asset:clear`.

<br>

#### Currency Manager

> *Jump is an opinionated setup*, and it was primarily intended for small stores, that's why it includes the Currency Manager too, by default.

Currency Manager can convert prices from one currency to another, can format prices in all currencies, and much more.

###### OpenExchangeRates API:

Currency Manager uses [OpenExchangeRates](https://openexchangerates.org/) API to determine current exchange rates for all currencies.

To use all features of the Currency Manager, register on [OpenExchangeRates](https://openexchangerates.org/) website and copy your **APP ID** to `OPENEXCHANGERATES_APP_ID` constant in `.env` file.

###### API:

```php
// Returns fresh exchange rates for all currencies.
// IMPORTANT: Requires OpenExchangeRates APP ID to work.
// Note: Base currency is the USD, it's rate is always equal to 1.
currency()->fresh(); // [ "USD" => 1, "EUR" => 0.929706 /* ... */ ]

// Returns cached exchange rates for all currencies.
// Works the same as ::fresh() method.
// Note: If rates are not cached fetches fresh rates and cache them.
currency()->rates(); // [ "USD" => 1, "EUR" => 0.929706 /* ... */ ]

// Returns a list of all supported currencies.
// IMPORTANT: Requires OpenExchangeRates APP ID to work.
currency()->all(); // [ "USD", "EUR" /* ... */ ]

// Returns information about all supported currencies.
// More info in: /resources/data/currency-format.json
currency()->format();

// Determines if a currency is supoprted.
currency()->exists('USD'); // true

// Returns the symbol of a currency.
currency()->symbol('USD'); // $

// Returns the representation template of the currency.
currency()->template('USD'); // $1

// Returns the exchange rate of a currency compared to the base currency.
// Note: Default base currency is USD.
currency()->rate('USD'); // 1

// Returns the exchange rate of a currency compared to EUR.
currency()->rate('USD', 'EUR'); // 1.0756088483886

// Returns a value only with two decimal places.
currency()->pretty(17.4321348); // 17.43

// Returns a value ending with .99
currency()->pretty(17.4321348, true); // 17.99

// Returns a value converted to a currency compared to the base currency.
// Note: Default base currency is USD.
currency()->value(17.432, 'USD'); // 17.43

// Returns a value converted to a currency compared to EUR.
currency()->value(17.432, 'USD', 'EUR'); // 18.75

// Returns a value converted to a currency compared to EUR, which ends in .99.
currency()->value(17.432, 'USD', 'EUR', true); // 18.99

// Formats a value in a currency compared to the base currency.
// Note: Default base currency is USD.
currency()->format(17.432, 'USD'); // $17.43

// Formats a value in a currency compared to EUR.
currency()->format(17.432, 'USD', 'EUR'); // $18.75

// Formats a value in a currency compared to EUR, which ends in .99.
currency()->format(17.432, 'USD', 'EUR'); // $18.99
```

> See more details in tests.

<br>

#### Beanstalkd Queues

Default queue driver in Jump is beanstalkd.

- [More details on Queues](https://laravel.com/docs/5.3/queues)

> You should have Beanstalkd installed on your machine. (Homestead have it installed by default)
