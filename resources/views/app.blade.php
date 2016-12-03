<!DOCTYPE html>
<html lang="{{ locale() }}">
<head>
    <meta charset="UTF-8">

    {!! meta()->toHtml() !!}

    <link rel="stylesheet" href="{{ asset()->url('/css/bundle.css') }}">

    {!! asset()->images() !!}
</head>
<body>
    <div id="app"></div>

    <script>window.APP_STORE = {!! data()->toJson('store') !!};</script>
    <script>window.APP_TRANS = {!! data()->toJson('translation') !!};</script>
    <script src="{{ asset()->url('/js/bundle.js') }}"></script>
</body>
</html>