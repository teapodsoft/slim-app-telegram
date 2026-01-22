<?php

namespace Teapodsoft\Applications\Settings;

/**
 * SettingsInterface
 *
 * @package Teapodsoft\Application\Settings
 * @description Интерфейс для работы с настройками
 */
interface SettingsInterface
{

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;

}
