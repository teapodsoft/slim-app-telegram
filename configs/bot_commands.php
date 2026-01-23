<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Teapodsoft\Telegram\Commands\InterfaceCommand;
use Teapodsoft\Telegram\Commands\StartCommand;
use Teapodsoft\Telegram\Commands\DemoCommand;

/**
 * Загрузка контейнера с настройками для бота
 *
 * Настройка заключается в том, что мы указываем
 * - Ключ = Команда для бота
 * - Значение = Класс для работы (храним всё в src/Telegram/Commands)
 */
return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        InterfaceCommand::class => function () {
            return [
                'start' => StartCommand::class,
                'demo' => DemoCommand::class,
            ];
        }
    ]);
};
