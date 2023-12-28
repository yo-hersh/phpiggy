<?php

// ini_set("memory_limit", '255M');

// echo ini_get("memory_limit");

print_r($_SERVER);

$app = include __DIR__.'/../src/app/bootstrap.php';

$app->run();