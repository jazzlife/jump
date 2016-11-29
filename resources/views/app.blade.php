<!DOCTYPE html>
<html lang="{{ locale() }}">
<head>
    <meta charset="UTF-8">

    {!! meta()->toHtml() !!}
</head>
<body>

    <script>window.APP_STORE = {!! data()->toJson('store') !!};</script>
    <script>window.APP_TRANS = {!! data()->toJson('translation') !!};</script>
</body>
</html>