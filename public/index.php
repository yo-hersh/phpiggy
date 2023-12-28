<?php

// ini_set("memory_limit", '255M');

// echo ini_get("memory_limit");

// include manually because the psr-4 is not autoloaded functions, only autoloaded classes
include __DIR__.'/../src/app/functions.php';


$app = include __DIR__.'/../src/app/bootstrap.php';

$app->run();

dd($_SERVER);