<?php

use Coderjerk\Cupsets\Controllers\HomeController;
use Coderjerk\Cupsets\Controllers\KnockoutController;
use Coderjerk\Cupsets\Controllers\MatchdayController;
use Coderjerk\Cupsets\Router;
use Coderjerk\Cupsets\DB;

require_once 'bootstrap.php';

DB::init();
$router = new Router();
$router->get('/', [HomeController::class, 'show']);
//$router->get('/games/', [MatchdayController::class, 'show']);
$router->get('/matchday/{id}', [MatchdayController::class, 'show']);
$router->get('/games/', [KnockoutController::class, 'show']);

echo $router->resolve();
