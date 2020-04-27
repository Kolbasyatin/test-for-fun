<?php

declare(strict_types=1);

require './vendor/autoload.php';


//** Requesty Example http://localhost:8000?category=22&type=xml */
//** Requesty Example http://localhost:8000?category=22&type=json */

$isProduction = true;

$kernel = new FakeKernel($isProduction);
$request = Request::create();

$response = $kernel->handle($request);

$response->send();
