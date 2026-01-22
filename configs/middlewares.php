<?php

declare(strict_types=1);

use Slim\App;
use Teapodsoft\Middlewares\ResponseJsonMiddleware;

/**
 * Описание обработчиков, которые будут использоваться
 * - Либо beforeAction
 * - Либо afterAction
 *
 * Все классы требуется расписывать в src/Middlewares
 */
return function (App $app) {
    $app->add(ResponseJsonMiddleware::class);
};

