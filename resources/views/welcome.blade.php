@extends('app')

@section('title', 'Főoldal')

@section('content')
@if(Auth::check())
    <p>Bejelentkezve, mint {{ Auth::user()->name }} - <a href="/logout">Kijelentkezés</a></p>
@else
<a href="/login">Bejelentkezés</a>
@endif
<h1>Járatok</h1>
<table>
    <tr>
        <th>Járatszám</th>
        <th>Ülések száma</th>
    </tr>
    @foreach($client->run("MATCH(f:FLIGHT) RETURN f LIMIT 20")->getResults() as $flight)
        <?php /** @var \Laudis\Neo4j\Types\CypherMap $flight */ ?>
    <tr>
        <td>{{ $flight['f']->getProperty('flightno') }}</td>
        <td>{{ $flight['f']->getProperty('seats') }}</td>
    </tr>
    @endforeach
</table>
@endsection
