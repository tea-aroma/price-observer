<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/pages/' . \Illuminate\Support\Facades\Route::currentRouteName() . '.css') }}">
</head>
<body>

@include('includes.header')

<main class="main">
    @yield('content')
</main>

<script src="{{ asset('assets/js/pages/' . \Illuminate\Support\Facades\Route::currentRouteName() . '.js') }}" type="module"></script>
</body>
</html>
