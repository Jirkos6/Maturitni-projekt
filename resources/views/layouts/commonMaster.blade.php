<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    @if (Route::currentRouteName() == 'dashboard-teams' || Route::currentRouteName() == 'global-events.show')
        @vite(['resources/js/teamattendance.js'])
    @elseif(Route::currentRouteName() == 'achievements.show')
        @vite(['resources/js/achievements.js'])
    @endif
    <title>@yield('title') | Kormorán </title>
    <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    @include('layouts/sections/styles')
    @include('layouts/sections/scriptsIncludes')
    @vite(['resources/js/app.js'])
</head>

<body>
    @yield('layoutContent')
    @include('layouts/contentFooterLayout')
    @include('layouts/sections/scripts')
</body>

</html>
