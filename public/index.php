<?php

use Coderjerk\Cupsets\Controllers\HomeController;
use Coderjerk\Cupsets\Controllers\MatchdayController;
use Coderjerk\Cupsets\Router;

require_once 'bootstrap.php';

$router = new Router();
$router->get('/', [HomeController::class, 'show']);
$router->get('/games/', [MatchdayController::class, 'show']);
$router->get('/matchday/{id}', [MatchdayController::class, 'show']);

echo $router->resolve();
