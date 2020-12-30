<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>{{ env('APP_NAME') }}</title>
    </head>

    <body class="d-flex flex-column min-vh-100">
        <div class="wrapper flex-grow-1" id="app">
            <main>
                <product-list/>
            </main>
        </div>
    </body>
</html>
