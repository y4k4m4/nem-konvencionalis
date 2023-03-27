<?php

use Laudis\Neo4j\ClientBuilder;

$beginsAt = microtime(true);

$client = ClientBuilder::create()
->withDriver('bolt', 'bolt://neo4j:12345678@database') // creates a bolt driver
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
