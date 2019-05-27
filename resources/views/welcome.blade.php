<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Robotoa:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css"> --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

    </head>
    <body>
        <div id="app">
            <main-app/>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
