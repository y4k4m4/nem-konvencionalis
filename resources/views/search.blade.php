@extends('app')

@section('title', 'Keresés')

@section('content')
<h1>Járatok</h1>
<form action="/search">
    <label>
        Innen:
        <select name="from">
            @foreach($airports as $airport)
                <option @if($airport == 'PDX') selected @endif>{{ $airport }}</option>
            @endforeach
        </select>
    </label>
    <label>
        Ide:
        <select name="to">
            @foreach($airports as $airport)
                <option @if($airport === 'DEN') selected @endif>{{ $airport }}</option>
            @endforeach
        </select>
    </label>
    <button type="submit">Keresés</button>
</form>
@if($shortest && $shortestDistance)
<p>A legrövidebb járat:</p>
<table>
    <tr>
        <th></th>
        <th>Indulás ideje</th>
        <th>Érkezés ideje</th>
        <th>Távolság</th>
        <th>Szabad helyek száma</th>
        <th>Műveletek</th>
    </tr>
    <tr>
        <td>Távolságtól függetlenül:</td>
        <td>{{ $shortest->startTime }}</td>
        <td>{{ $shortest->arrivalTime }}</td>
        <td>{{ $shortest->distance }}</td>
        <td>{{ $shortest->seats }}</td>
        <td><a href="/reserve?from={{$shortest->from}}&to={{$shortest->to}}&dist=false">Foglalás</a></td>
    </tr>
    <tr>
        <td>Távolság figyelembevételével:</td>
        <td>{{ $shortestDistance->startTime }}</td>
        <td>{{ $shortestDistance->arrivalTime }}</td>
        <td>{{ $shortestDistance->distance }}</td>
        <td>{{ $shortestDistance->seats }}</td>
        <td><a href="/reserve?from={{$shortest->from}}&to={{$shortest->to}}&dist=true">Foglalás</a></td>
    </tr>
</table>
@endif
@endsection
