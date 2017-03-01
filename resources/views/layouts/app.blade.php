<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Filesmanager</title>

        <!-- Styles -->
        @include('layouts.partials.styles')
        @yield('css')
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>
        <footer>
            @include('layouts.partials.scripts')
            @yield('js')
        </footer>
    </body>
</html>

