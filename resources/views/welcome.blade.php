<?php

use Laudis\Neo4j\ClientBuilder;

$beginsAt = microtime(true);

$client = ClientBuilder::create()
->withDriver('bolt', 'bolt://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST')) // creates a bolt driver
->withDefaultDriver('bolt')
->build();

use Laudis\Neo4j\Contracts\TransactionInterface;

$result = $client->writeTransaction(static function (TransactionInterface $tsx) {
$result = $tsx->run('MATCH (n) RETURN n');
/** @var \Laudis\Neo4j\Types\Node $node */
$node = $result->first()->get('n');
return $node->getProperty('name');
});

var_dump($result);
echo "Time: ".(microtime(true) - $beginsAt);
