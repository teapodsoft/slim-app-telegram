<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Teapodsoft\Routes\{MainRoute, WebhookRoute, SwaggerRoute};
use Teapodsoft\Routes\Bot\{BotMeRoute, UpdatesRoute};
use Teapodsoft\Routes\Bot\Hook\{HookGetRoute, HookDeleteRoute, HookSetRoute};

/**
 * Настройка маршрутизации приложения
 */
return function (App $app) {
    // Базовые настройки приложения
    $app->get(pattern: '/', callable: MainRoute::class);
    $app->get(pattern: '/json-schema', callable: SwaggerRoute::class);
    $app->any(pattern: '/webhook', callable: WebhookRoute::class);

    // Обработчики для Telegram Bot
    $app->group(pattern: '/bot', callable: function (RouteCollectorProxy $group) {
        $group->get(pattern: '/me', callable: BotMeRoute::class);
        $group->get(pattern: '/updates', callable: UpdatesRoute::class);
        $group->group('/hook', function (RouteCollectorProxy $group) {
            $group->get(pattern: '/set', callable: HookSetRoute::class);
            $group->get(pattern: '/get', callable: HookGetRoute::class);
            $group->get(pattern: '/delete', callable: HookDeleteRoute::class);
        });
    });
};
