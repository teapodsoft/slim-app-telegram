<?php

declare(strict_types=1);

 use Psr\Http\Server\MiddlewareInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Teapodsoft\{Secrets};
use Teapodsoft\Applications\Handlers\ErrorJsonHandler;
use Teapodsoft\Applications\Interfaces\{BotApiInterface, BotClientInterface, CommandInterface};
use Teapodsoft\Applications\Interfaces\SwaggerInterface;
use Teapodsoft\Applications\Middlewares\ResponseJsonMiddleware;
use Teapodsoft\Telegram\Commands\{DemoCommand, StartCommand};
use TelegramBot\Api\{BotApi, Client};

/**
 * Файл с настройками приложения
 */
return [
    // Настройки необходимых middleware (beforeAction и afterAction)
    MiddlewareInterface::class => [
        ResponseJsonMiddleware::class,
    ],

    // Настройка ErrorHandler для работы
    ErrorHandlerInterface::class => ErrorJsonHandler::class,

    // Swagger
    SwaggerInterface::class => [
        dirname(getcwd()) . '/src/Routes',
    ],

    // Настройки Telegram Bot клиента для запуска консольных команд
    CommandInterface::class => [
        'start' => StartCommand::class,
        'demo' => DemoCommand::class,
    ],

    // Настройка BotApi для работы с Telegram
    BotApiInterface::class => function () {
        return new BotApi(Secrets::get('TOKEN', '', 'telegram'));
    },

    // Настройка BotClient для работы с Telegram
    BotClientInterface::class => function () {
        return new Client(Secrets::get('TOKEN', '', 'telegram'));
    },

];
