<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{(getSettingInfo('company_name') != "" ? getSettingInfo('company_name') : Config::get('constants.AppnameGlobe') ) }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    @if(getSettingInfo('favicon')!="")
    <link rel="shortcut icon" href="{{ URL::asset('uploads/settings/'.getSettingInfo('favicon')) }}">
    @endif
    @include('layouts.front.head-css')
</head>


    <body id="landing-page" class="@yield('body-class', '')">
    @include('layouts.front.header')
    @yield('content')
    @include('layouts.front.footer')
    <!-- JAVASCRIPT -->
    @include('layouts.front.footer-js')
</body>

</html>
