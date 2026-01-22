<?php

namespace Teapodsoft\Composer;

use Composer\Script\Event;

/**
 * Installer
 *
 * @package Teapodsoft\Composer
 * @description Обработчик для Composer. Помогает настраивать окружение для работы после команды ```shell composer install ```
 */
class Installer
{

    /**
     * Обработчик postInstall для Composer. Запускается после того как прошла обработка команды composer install
     *
     * @param Event $event
     * @return void
     */
    public static function postInstall(Event $event): void
    {
        static::runCommands($event, __METHOD__);
    }

    /**
     * Копирование файлов из директории в директорию
     *
     * @param array $paths
     * @return void
     */
    public static function copyFiles(array $paths): void
    {
        $sourcePath = getcwd();
        $paths = $paths[0];

        foreach ($paths as $sourceFile => $targetFile) {
            if (!file_exists($sourceFile . '/' . $targetFile)) {
                @copy(
                    from: $sourcePath . '/' . $sourceFile,
                    to: $sourcePath . '/' . $targetFile
                );
            }
        }
    }

    /**
     * Создание директорий для работы приложения и установка пермишанов у каждой
     *
     * @param array $paths
     * @return void
     */
    public static function createPaths(array $paths): void
    {
        $sourcePath = getcwd();
        $paths = $paths[0];

        foreach ($paths as $path => $permissions) {
            if (!is_dir($sourcePath . '/' . $path)) {
                @mkdir($sourcePath . '/' . $path, $permissions);
            }
        }
    }

    /**
     * @param Event $event
     * @param $extraKey
     * @return void
     */
    protected static function runCommands(Event $event, $extraKey): void
    {
        $params = $event->getComposer()->getPackage()->getExtra();
        if (isset($params[$extraKey]) && is_array($params[$extraKey])) {
            foreach ($params[$extraKey] as $method => $args) {
                call_user_func_array([__CLASS__, $method], (array($args)));
            }
        }
    }

}
