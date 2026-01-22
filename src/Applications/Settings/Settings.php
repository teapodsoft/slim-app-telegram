<?php

namespace Teapodsoft\Applications\Settings;

/**
 * Settings
 *
 * @package Teapodsoft\Application\Settings
 * @description Класс для работы с настройками, которые указаны в configs/settings.php файле
 */
readonly class Settings implements SettingsInterface
{

    /**
     * @param array $settings
     */
    public function __construct(
        private array $settings = [],
    )
    {
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }

}
