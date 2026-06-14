<?php

use Coderjerk\Cupsets\Controllers\HomeController;
use Coderjerk\Cupsets\Controllers\MatchdayController;
use Coderjerk\Cupsets\Controllers\TeamController;
use Coderjerk\Cupsets\DB;
use Coderjerk\Cupsets\Router;

require_once 'bootstrap.php';

DB::init();


$router = new Router();
$router->get('/', [HomeController::class, 'show']);
$router->get('/matchday/{id}', [MatchdayController::class, 'show']);
//$router->get('/teams/{id}', [TeamController::class, 'show']);
//$router->post('/teams/{id}', [TeamController::class, 'create']);

echo $router->resolve();
