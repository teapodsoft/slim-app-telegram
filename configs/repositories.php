<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use Teapodsoft\Secrets;

/**
 * Обработик настроек, при которых всё загружается в контейнер для работы
 *
 * Использование внутри приложения
 * ```php
 * $containerBlock = $this->get('containerBlock');
 * ```
 */
return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'botApi' => new BotApi(Secrets::get('TOKEN', '', 'telegram')),
        'botClient' => new Client(Secrets::get('TOKEN', '', 'telegram')),
    ]);
};
