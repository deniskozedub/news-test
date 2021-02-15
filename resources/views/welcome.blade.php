<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>News</title>
</head>
<body>
<div id="app"></div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
