<!doctype html>
<html lang="en">

<head>
    <title>@yield('title') - Utazási iroda</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link type="text/css" href="{{ asset('static/app.css') }}" rel="stylesheet">
</head>

<body>
@if(Auth::check())
    <p>Bejelentkezve, mint {{ Auth::user()->name }} - <a href="/logout">Kijelentkezés</a></p>
@else
    <a href="/login">Bejelentkezés</a>
@endif
<div>
    <a href="/">Főoldal</a>
    <a href="/search">Keresés</a>
</div>
@yield('content')
</body>

</html>
