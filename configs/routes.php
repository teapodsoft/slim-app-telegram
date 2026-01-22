<?php

declare(strict_types=1);

use Slim\App;
use Teapodsoft\Actions\TestAction;
use Teapodsoft\Actions\CorsAction;

/**
 * Настройка маршрутизации приложения
 */
return function (App $app) {
    $app->options(pattern: '/{routes:.+}', callable: CorsAction::class);

    // Обработка главной страницы
    $app->get(pattern: '/', callable: TestAction::class);

};
