
<p align="center">
    <img src="./resources/jump.png" width="140" height="197">
</p>

<br>

**Jump** is an opinionated setup of [Lumen](https://lumen.laravel.com/) micro-framework, preconfigured / modified to allow Developers to create Single Page Applications a lot faster using modern technologies.

<br>

### What's in the box?

---

- [**Lumen** 5.3.2](#lumen) 
- [**VueJS** 2.1.4](#vuejs)
- [**Vuex** 2.0.0](#vuex)
- [**Vue-Router** 2.1.1](#vue-router)
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

<br>

### Installation

---

> **Note:** Jump requires PHP 7.0 or later.

```bash
# First, download source files.
git clone https://github.com/sumanion/spa
cd spa

# Then, install composer dependencies.
# Note: You should have composer installed.
composer install

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

Jump uses Lumen micro-framework on backend, at least for now, because it is blazing fast and easy to use.

- [Lumen Docs](https://lumen.laravel.com/docs/5.3)

<br>

#### VueJS

To build powerful client interfaces Jump uses *the most progressive* JavaScript framework - **VueJS**.

- [VueJS Docs](http://vuejs.org/v2/guide/)

<br>

#### Vuex

Vuex is a state management pattern + library for VueJS applications. It serves as a centralized store for all the components in an application, with rules ensuring that the state can only be mutated in a predictable fashion.

- [Vuex Docs](https://vuex.vuejs.org/)

<br>

#### Vue-Router

A powerful router for VueJS SPAs.

- [Vue-Router Docs](https://router.vuejs.org/)

<br>

#### MongoDB

*MongoDB is an open source database that uses a document-oriented data model. MongoDB is one of several database types to arise in the mid-2000s under the NoSQL banner. Instead of using tables and rows as in relational databases, MongoDB is built on an architecture of collections and documents.*

Jump uses MongoDB by default, as the main database, because of it's power, flexibility, scalability and performance.

- [MongoDB Official Website](https://www.mongodb.com/)
- [Install MongoDB on Dev Machine](https://docs.mongodb.com/manual/installation/)
- [Install MongoDB PHP Driver on Dev Machine](http://php.net/manual/en/mongodb.setup.php)
- [All-In-One installer for Homestead](https://github.com/zakhttp/Mongostead7)
- [Use MongoDB with Eloquent](https://github.com/jenssegers/laravel-mongodb)
- [Cross-Platform MongoDB Manager](https://robomongo.org/)

> **Note:** *laravel-mongo* package is already installed and configured.

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

> **Important:** You should have Redis installed on your machine. (Homestead have it installed by default)

- [Redis Official Website](https://redis.io/)

*You can use Redis facade to execute Redis commands.*
[*More details*](https://laravel.com/docs/5.3/redis)

> **Note:** *predis/predis* package is already installed.

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

<br>

#### Stylus

Stylus is a revolutionary new language, providing an efficient, dynamic, and expressive way to generate CSS. Jump uses Stylus in Vue compoenents and to create main style of the application.

- [Stylus Docs](http://stylus-lang.com/)

<br>

#### Rupture

Rupture is a utility for working with media queries in stylus. It takes advantage of stylus' new block mixins to provide useful helpers that make breakpoints much more clear to read and simple to code. Rupture is based loosely on breakpoint-slicer, a sass plugin with similar functionality.

Jump loads Rupture in Vue compoenents styled with Stylus and in Stylus files compiled by the application.

- [Rupture Docs](http://jescalan.github.io/rupture/)

<br>

#### Lost Grids

Lost Grids is a powerful grid system built in PostCSS that works with any preprocessor and even vanilla CSS.

Jump loads Lost Grids in Vue compoenents styled with Stylus and in Stylus files compiled by the application.

- [Lost Grids Docs](http://lostgrid.org/docs.html)

<br>

#### Lodash

Lodash is A modern JavaScript utility library delivering modularity, performance & extras.

- [Lodash Docs](https://lodash.com/docs/4.17.4)

<br>

#### Modernizr

Modernizr is a JavaScript library that detects which HTML5 and CSS3 features your visitor's browser supports.

- [Modernizr Docs](https://modernizr.com/docs)

<br>

#### Babel ES6 Polyfills

This will emulate a full ES2015 environment and is intended to be used in an application rather than a library/tool. 

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
2. Create a New Project.
3. On the **"Configure your application"** page click **"Get your DSN"**.
4. Copy **URL** from **DSN** to `SENTRY_PRIVATE_DSN` variable in the `.env` file.
5. Copy **URL** from **Public DSN** to `SENTRY_PUBLIC_DNS` variable in the `.env` file.
6. Now, all `PHP` and `JavaScript` errors will be reported to your Sentry dashboard.

<br>

#### Multiple Languages

Lumen, by default, supports multiple languages and in Jump we enhanced this feature a bit, so now you can change the language from the URL.

> **Note:** If no language is passed in the query string (`hl` parameter), the preferred language will be matched automatically.

###### Usage:

1. Add a comma separated list of languages available in your application to the `APP_LOCALES` variable to the `.env` file. (ex: `APP_LOCALES=en,fr,es,ru`)
2. Set the default language to the `APP_LOCALE` variable in the `.env` file.
3. Set the fallback language to the `APP_FALLBACK_LOCALE` variable in the `.env` file.
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

<br>

#### RequestToken Manager

In Jump, every AJAX request must be signed with a Token. 

RequestToken Managed is already integrated and configured in Jump and every request made with *Axios* is signed with the right Token.

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

###### Routes:

- Routes which should be signed with a Token must be placed in `/routes/api.php` file.
- Routes which can be both signed and not signed with a Token must be placed in `/routes/web.php` file.

> **Note:** See tests for details.

<br>

#### Request Throttling

Jump allows only `60` Ajax request per minute from an IP address and `120` regular HTTP requests per minute from an IP address.

> **Note:** These limits can me modified in `/bootstrap/app.php`


<br>

#### Data Manager

Data Manager is a Class which contains a store of key-value pairs with data used by the Vue Components and the translation of the Application.

Data Manager sends it's values to Vuex Store.

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

// Return all store values from all loaded Data Managers.
data()->toArray('store');

// Add a new store value to the Data Manager.
data()->set('store', 'key', 'value');

// Remove a store value from the Data Manager.
data()->remove('store', 'key');

// Add a new translated value to the Data Manager.
data()->set('translation', 'key', 'value');

// Remove a translated value from the Data Manager.
data()->remove('translation', 'key');

// Return all translated values from all loaded Data Managers.
data()->toArray('translation');
```

<br>

#### Meta Manager

Meta Manager is a Class wich helps to add meta tags to the Application.

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

// Add: <meta name="foo" content="bar">
meta()->foo = 'bar';

// Return all meta fields from all loaded Meta Managers.
meta()->fields();

// Convert meta fields to HTML tags.
meta()->toHtml();
```

<br>

#### Asset Manager

###### Environment Variables:

```bash

# Amazon S3 Credentials.
S3_KEY=
S3_SECRET=
S3_REGION=
S3_BUCKET=

ASSETS_USE_CDN=true|false
ASSETS_CDN_URL=<Amazon CloudFront Url>

# Paths to assets which must be uploaded to Amazon S3.
ASSETS_IMAGES_PATH=<images/>
ASSETS_STYLES_PATH=<css/>
ASSETS_SCRIPTS_PATH=<js/>
```

###### Commands:

```bash
# Upload images to Amazon S3.
php artisan asset:push images

# Upload scripts to Amazon S3.
php artisan asset:push scripts

# Upload styles to Amazon S3.
php artisan asset:push styles
```