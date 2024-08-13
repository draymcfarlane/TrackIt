<?php

// database configuration
require __DIR__. '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
    ->withServiceAccount('trackit-a7b4e-firebase-adminsdk-r025p-09150443bc.json')
    ->withDatabaseUri('https://trackit-a7b4e-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase(); // creates variable for database
$auth = $factory->createAuth(); // creates variable for authentication