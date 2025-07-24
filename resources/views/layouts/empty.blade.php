<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles

    <style>
        html, body {
    overflow: hidden;
    height: 100%;
    margin: 0;
    padding: 0;
}
    </style>
</head>
<body class="bg-gray-900">
    {{ $slot }}
    @livewireScripts
</body>
</html>