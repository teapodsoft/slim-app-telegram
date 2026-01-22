<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Teapodsoft\Applications\Settings\Settings;
use Teapodsoft\Applications\Settings\SettingsInterface;

/**
 * Загрузка контейнера с настройками для дальнейшего использования внутри приложения
 */
return function (ContainerBUilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true,
                'logError' => false,
                'logErrorDetails' => false,
            ]);
        },
    ]);
};
