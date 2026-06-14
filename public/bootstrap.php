<?php

use Coderjerk\Cupsets\Cupsets;
use Coderjerk\Cupsets\DB;


function bootstrap(): void
{
    require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
    $dotenv->load();

    DB::init();
}

bootstrap();
