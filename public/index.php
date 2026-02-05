<?php

use Teapodsoft\Applications\Application;
use Teapodsoft\Env;

$rootPath = dirname(__DIR__);

require_once $rootPath . '/vendor/autoload.php';

Env::load($rootPath, '.env');

new Application(
    routes: require $rootPath . '/configs/routes.php',
    config: require $rootPath . '/configs/config.php',
)->run();
