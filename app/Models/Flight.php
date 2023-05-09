<?php

namespace App\Models;

use Laudis\Neo4j\Contracts\ClientInterface;
use Laudis\Neo4j\Types\CypherMap;
use Laudis\Neo4j\Types\Node;
use Laudis\Neo4j\Types\Relationship;

class Flight {
    public string $from;
    public string $to;
    public int $distance;
    public string $startTime;
    public string $arrivalTime;
    public int $weight;
    public int $seats;
    public function __construct() {
    }

    public static function getShortestFlight(string $from, string $to): ?Flight {
        $client = \App::make(ClientInterface::class);
        $results = $client->run("MATCH p = shortestPath(({name:'$from'})-[*]->({name:'$to'})) RETURN nodes(p) AS list, relationships(p) as relations")->getResults();
        return self::getFlightFromResult($results, $from, $to);
    }

    public static function getShortestDistanceFlight(string $from, string $to): ?Flight {
        $client = \App::make(ClientInterface::class);
        $results = $client->run("
            MATCH (from:AIRPORT {name: '$from'}), (to: AIRPORT {name: '$to'})
            CALL apoc.algo.dijkstra(from, to, 'STARTS>|ARRIVES>', 'distance') YIELD path, weight
            RETURN nodes(path) AS list, relationships(path) as relations, weight
        ")->getResults();
        $flight = self::getFlightFromResult($results, $from, $to);
        $flight->weight = $results->first()['weight'];
        return $flight;
    }

    private static function getTime(int $time): string {
        $hr = (int) ($time / 100);
        $min = $time % 100;
        return sprintf("%02d:%02d", $hr, $min);
    }

    /**
     * @param $results
     * @param string $from
     * @param string $to
     * @return Flight|null
     */
    public static function getFlightFromResult($results, string $from, string $to): ?Flight {
        if ($results->count() == 0) {
            return null;
        }
        /** @var CypherMap $relations */
        $relations = $results->first()['relations'];
        $first = $relations->first();
        $last = $relations->last();
        $flight = new Flight();
        $flight->from = $from;
        $flight->to = $to;
        /** @var Relationship $first */
        if ($first->getType() === 'STARTS') {
            $flight->startTime = self::getTime($first->getProperty('starttime'));
        } else {
            throw new \RuntimeException('Missing flight start edge!');
        }
        /** @var Relationship $last */
        if ($last->getType() === 'ARRIVES') {
            $flight->arrivalTime = self::getTime($last->getProperty('arrivaltime'));
        } else {
            throw new \RuntimeException('Missing flight arrival edge!');
        }
        $flight->distance = $relations->reduce(fn(int $sum, Relationship $relation) => $sum + $relation->getProperty('distance'), 0);

        $list = $results->first()['list'];
        $seats = PHP_INT_MAX;
        foreach ($list as $flightNode) {
            /** @var Node $flightNode */
            if ($flightNode->getLabels()->hasValue('FLIGHT')) {
                $seats = min($flightNode->getProperty('seats'), $seats);
            }
        }
        $flight->seats = $seats;
        return $flight;
    }
}
