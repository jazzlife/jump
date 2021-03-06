<!DOCTYPE html>
<html lang="{{ locale() }}">
<head>
    <meta charset="UTF-8">

    {!! meta()->toHtml() !!}

    @foreach (array_diff(locales(), [ locale() ]) as $locale)
        <link rel="alternate" href="{{ url_add_locale(app('request')->fullUrl(), $locale) }}" hreflang="{{ $locale }}">
    @endforeach

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,400i,700&subset=cyrillic">

    <link rel="stylesheet" href="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.9/css/uikit.css') }}">
    <link rel="stylesheet" href="{{ asset()->url('/css/bundle.css') }}">

    <style>{!! asset()->css() !!}</style>

    <noscript>
        <meta http-equiv="refresh" content="0; url=/bad-browser">
    </noscript>
</head>
<body>
    <div id="app"></div>

    @if (env('SENTRY_PUBLIC_DSN'))
        <script src="https://cdn.ravenjs.com/3.8.0/raven.min.js"></script>
        <script>Raven.config('{{ env('SENTRY_PUBLIC_DSN') }}').install();</script>
    @endif

    <script>window.APP_STORE = {!! data()->toJson('store') !!};</script>
    <script>window.APP_TRANS = {!! data()->toJson('translation') !!};</script>

    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.16.0/polyfill.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/string-format/0.5.0/string-format.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/store.js/1.3.20/store.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.runtime.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/vue-router/2.2.0/vue-router.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/vuex/2.1.1/vuex.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js') }}"></script>
    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.9/js/uikit.js') }}"></script>
    <script src="{{ asset()->url('/js/bundle.js') }}"></script>

    <script src="{{ cdnjs('https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.js') }}"></script>
    <script>FastClick.attach(document.body);</script>

    @include('trackers.analytics')
    @include('trackers.pixel')
</body>
</html>