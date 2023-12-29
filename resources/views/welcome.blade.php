<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="{{ url('/public/favicon-16x16.png') }}">
        <link rel="shortcut icon" type="image/png" sizes="32x32" href="{{ url('/public/favicon-32x32.png') }}">
        <link rel="shortcut icon" type="image/png" sizes="192x192" href="{{ url('/public/favicon-192x192.png') }}">
        <link rel="shortcut icon" href="{{ url('/public/favicon.ico') }}">
        <title>Apparelity</title>
        @vite(['resources/css/app.css', 'resources/js/app.ts'])
    </head>
    <body class="antialiased">
        <div id="app"></div>
    </body>
</html>