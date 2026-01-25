<?php

use Teapodsoft\Applications\Application;
use Teapodsoft\Env;

require_once dirname(__DIR__) . '/vendor/autoload.php';

Env::load(dirname(__DIR__), '.env');

new Application(
    config: require dirname(__DIR__) . '/configs/config.php',
    routes: require dirname(__DIR__) . '/configs/routes.php',
)->run();
