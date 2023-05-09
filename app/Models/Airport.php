<?php

namespace App\Models;

use Laudis\Neo4j\Contracts\ClientInterface;
use Laudis\Neo4j\Types\CypherMap;
use Laudis\Neo4j\Types\Node;
use Laudis\Neo4j\Types\Relationship;

class Airport {
    public function __construct() {
    }

    public static function getList(): array {
        $client = \App::make(ClientInterface::class);
        $results = $client->run("MATCH (airport:AIRPORT) RETURN airport")->getResults();
        $ret = [];
        if ($results->count() == 0) {
            return $ret;
        }
        foreach ($results as $result) {
            $airport = $result['airport'];
            /** @var Node $airport */
            $ret[] = $airport->getProperty('name');
        }
        return $ret;
    }

    private static function getTime(int $time): string {
        $time = $time.'';
        $hr = substr($time, 0, 2);
        $min = substr($time, 2);
        return $hr.':'.$min;
    }
}
