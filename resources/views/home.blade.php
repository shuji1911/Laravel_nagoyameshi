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
<body class="top-page">
    <div id="app">
        @include('layouts.header')

        <main class="py-4">
            <div class="d-flex justify-content-center align-items-center top-wrapper">
                <div class="d-flex justify-content-center">
                    <div class="search-area px-5 py-4">
                        <h1 class="mt-2">名古屋のB級グルメを探す</h1>
                        <form method="GET" action="{{ route('admin.restaurants.index') }}" class="search-box mb-3">
                            <div class="d-flex flex-wrap flex-sm-nowrap">
                                <div class="me-2 mb-2">
                                    <input type="text" class="form-control" placeholder="店名" name="keyword">
                                </div>
                                <div class="me-2 mb-2 category-select">
                                    <select class="form-control form-select" id="category_id" name="category_id">   
                                        <option value="">カテゴリ</option>                                             
                                        @foreach ($categories as $category)                                        
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>                                        
                                        @endforeach                              
                                    </select>    
                                </div>
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary shadow-sm text-nowrap">検索</button> 
                                </div>                                                     
                            </div>               
                        </form>                      
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</body>
</html>
