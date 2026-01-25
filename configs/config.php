<?php

declare(strict_types=1);

use Teapodsoft\Applications\Middlewares\ResponseJsonMiddleware;
use Teapodsoft\Applications\Settings\SettingsInterface;
use Teapodsoft\Applications\SwaggerInterface;
use Teapodsoft\Telegram\Commands\CommandInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Файл с настройками приложения
 */
return [
    // Настройки необходимых middleware (beforeAction и afterAction)
    MiddlewareInterface::class => [
        ResponseJsonMiddleware::class,
    ],

    // Настройки приложения для работы
    SettingsInterface::class => [
        'displayErrorDetails' => true,
        'logErrors' => false,
        'logErrorDetails' => false,
    ],

    // Настройки для работы со Swagger. Передаем директории для чтения
    SwaggerInterface::class => [
        $_SERVER['DOCUMENT_ROOT'] . '/src/Routes',
    ],

    // Настройки Telegram Bot клиента для запуска консольных команд
    CommandInterface::class => [
        'start' => \Teapodsoft\Telegram\Commands\StartCommand::class,
        'demo' => \Teapodsoft\Telegram\Commands\DemoCommand::class,
    ],

];
