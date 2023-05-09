@extends('app')

@section('title', 'Bejelentkezés')

@section('content')
<h1>Bejelentkezés</h1>
<form action="/login/doit" method="get">
    <label>
        Név:
        <input type="text" name="name">
    </label>
    <label>
        Jelszó:
        <input type="password" name="password">
    </label>
    <input type="submit" value="Bejelentkezés">
</form>
@endsection
