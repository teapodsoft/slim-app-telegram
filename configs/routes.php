<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Teapodsoft\Actions\CorsAction;
use Teapodsoft\Actions\Swagger\SwaggerAction;
use Teapodsoft\Actions\Telegram\Bot\GetUpdateAction;
use Teapodsoft\Actions\Telegram\Bot\MeAction;
use Teapodsoft\Actions\Telegram\Hook\HookGetAction;
use Teapodsoft\Actions\Telegram\Hook\HookSetAction;
use Teapodsoft\Actions\Telegram\Hook\HookDeleleAction;
use Teapodsoft\Actions\Telegram\HookAction;
use Teapodsoft\Actions\TestAction;

/**
 * Настройка маршрутизации приложения
 */
return function (App $app) {
    // Обработка главной страницы
    $app->get(
        pattern: '/',
        callable: TestAction::class
    );

    // Обработка для Swagger. Передача JSON структуры для загрузки в Swagger UI
    $app->get(
        pattern: '/json-schema',
        callable: SwaggerAction::class
    );

    // Обработка результатов от бота, который присылает данные на https://bot.domain.ltd/webhook
    $app->any(
        pattern: '/webhook',
        callable: HookAction::class
    );

    // Обработка логики запросов от хука для Telegram API
    $app->group(
        pattern: '/bot',
        callable: function (RouteCollectorProxy $group
        ) {

            // Обработка /bot/me
            $group->get(
                pattern: '/me',
                callable: MeAction::class
            );

            // Обработка /bot/update
            $group->get(
                pattern: '/update',
                callable: GetUpdateAction::class
            );

            $group->group('/hook', function (RouteCollectorProxy $group) {
                // Обработка /bot/hook/set
                $group->get(
                    pattern: '/set',
                    callable: HookSetAction::class
                );

                // Обработка /bot/hook/get
                $group->get(
                    pattern: '/get',
                    callable: HookGetAction::class
                );

                $group->get(
                    pattern: '/delete',
                    callable: HookDeleleAction::class,
                );

            });

        });
};
