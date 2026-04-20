<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Login' }}</title>

    @php
        $espireBase = 'Espire/espireadmin-10/Espire - Bootstrap Admin Template/html/demo/app';
        $espireAsset = fn (string $path) => url(str_replace('%2F', '/', rawurlencode($espireBase.'/assets/'.$path)));
    @endphp

    <link rel="shortcut icon" href="{{ $espireAsset('images/logo/favicon.ico') }}">
    <link href="{{ $espireAsset('css/app.min.css') }}" rel="stylesheet">
</head>
<body>
    @yield('content')

    <script src="{{ $espireAsset('js/vendors.min.js') }}"></script>
    <script src="{{ $espireAsset('js/app.min.js') }}"></script>
</body>
</html>