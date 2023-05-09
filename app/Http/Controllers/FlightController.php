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
}
