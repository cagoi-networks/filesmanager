<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Filesmanager</title>

        @include('layouts.partials.styles')
    </head>
    <body>
        <div id="app">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <footer>
            @include('layouts.partials.scripts')
        </footer>
    </body>
</html>

