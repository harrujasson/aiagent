<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | {{(getSettingInfo('company_name') != "" ? getSettingInfo('company_name') : Config::get('constants.AppnameGlobe') ) }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">       
       
        <!-- App favicon -->
         @if(getSettingInfo('favicon')!="")
    <link rel="shortcut icon" href="{{ URL::asset('uploads/settings/'.getSettingInfo('favicon')) }}">
    @endif
        @include('layouts.head-css')
  </head>

    @yield('body')

    @yield('content')

    @include('layouts.vendor-scripts')
    </body>
</html>
