<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;

$factory = (new Factory)
    ->withServiceAccount('php-firebase-exploration-firebase-adminsdk-fbsvc-23fc43f5b9.json')
    ->withDatabaseUri('https://php-firebase-exploration-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

?>