<?php

declare(strict_types=1);

use DI\ContainerBuilder;

/**
 * Обработик настроек, при которых всё загружается в контейнер для работы
 * Обработка идет по принципу
 * - (Интерфейс) => Обработчик
 * - InterfaceName => ClassName
 *
 * Всё пишется в контейнер и используется для последующей работы
 */
return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        //NameRepositoryInterface::class => \DI\autowire(NameRepository::class),
    ]);
};
