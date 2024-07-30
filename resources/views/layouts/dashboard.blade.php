<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="{{ asset('/css/nagoyameshi.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.header')

        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">            
                    @include('layouts.sidebar')
                </div>
                <div class="col">
                    <main class="py-4">            
                        @yield('content')
                    </main>            
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</body>
</html>
