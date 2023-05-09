@extends('app')

@section('title', 'Főoldal')

@section('content')
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
