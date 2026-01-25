<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * Настройка маршрутизации приложения
 */
return function (App $app) {
    // Базовые настройки приложения
    $app->get(pattern: '/', callable: \Teapodsoft\Routes\MainRoute::class);
    $app->get(pattern: '/json-schema', callable: \Teapodsoft\Routes\SwaggerRoute::class);
    $app->any(pattern: '/webhook', callable: \Teapodsoft\Routes\WebhookRoute::class);

    // Обработчики для Telegram Bot
    $app->group(pattern: '/bot', callable: function (RouteCollectorProxy $group) {
        $group->get(pattern: '/me', callable: \Teapodsoft\Routes\Bot\BotMeRoute::class);
        $group->get(pattern: '/updates', callable: \Teapodsoft\Routes\Bot\UpdatesRoute::class);
        $group->group('/hook', function (RouteCollectorProxy $group) {
            $group->get(pattern: '/set', callable: \Teapodsoft\Routes\Bot\Hook\HookSetRoute::class);
            $group->get(pattern: '/get', callable: \Teapodsoft\Routes\Bot\Hook\HookGetRoute::class);
            $group->get(pattern: '/delete', callable: \Teapodsoft\Routes\Bot\Hook\HookDeleteRoute::class);
        });
    });
};
