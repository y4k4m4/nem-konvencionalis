<?php namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller {
    public function search(Request $request) {
        $data = [
            'airports' => Airport::getList(),
            'shortest' => null,
            'shortestDistance' => null
        ];
        if ($request->has('from') && $request->has('to')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $data['shortest'] = Flight::getShortestFlight($from, $to);
            $data['shortestDistance'] = Flight::getShortestDistanceFlight($from, $to);
        }
        return view('search', $data);
    }

    public function reserve(Request $request) {
        if(!\Auth::check()) {
            return redirect('/login');
        }
        $from = $request->get('from');
        $to = $request->get('to');
        $flight = $request->get('dist') === 'true'
            ? Flight::getShortestDistanceFlight($from, $to) : Flight::getShortestFlight($from, $to);
        $flight->reserve(\Auth::user());
        // Újra lekérdezzük, hogy csökkentve legyen a helyek száma
        $data['flight'] = $request->get('dist') === 'true'
            ? Flight::getShortestDistanceFlight($from, $to) : Flight::getShortestFlight($from, $to);
        return view('reservation', $data);
    }
}
