<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;

$factory = (new Factory)
    ->withServiceAccount('php-firebase-exploration-firebase-adminsdk-fbsvc-8867f56bd2.json')
    ->withDatabaseUri('https://php-firebase-exploration-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

?>