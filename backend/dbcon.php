<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
    ->withServiceAccount('serviceAccountKey.json')
    ->withDatabaseUri('https://php-firebase-exploration-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
?>