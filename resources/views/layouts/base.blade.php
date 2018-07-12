<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Site data -->
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Additional -->
@stack('metadata')

<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <script>window.AppData = {};</script>
</head>
<body>
<!-- Background -->
<div class="background-fixed"></div>
<!-- Main -->
<div id="app">
    @yield('content')
</div>
<!-- JavaScript -->
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>