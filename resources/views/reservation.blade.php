@extends('app')

@section('title', 'Foglalás')

@section('content')
<h2>Sikeres foglalás</h2>
<table>
    <tr>
        <th>Indulás ideje</th>
        <th>Érkezés ideje</th>
        <th>Távolság</th>
        <th>Szabad helyek száma</th>
    </tr>
    <tr>
        <td>{{ $flight->startTime }}</td>
        <td>{{ $flight->arrivalTime }}</td>
        <td>{{ $flight->distance }}</td>
        <td>{{ $flight->seats }}</td>
    </tr>
</table>
@endsection
