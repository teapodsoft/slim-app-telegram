<?php

namespace Teapodsoft\Helpers;

/**
 * @package Teapodsoft\Helpers
 * @description Класс для чтения файла composer.json по передаче информации внутрь скрипта
 */
class ScriptInfo
{

    /**
     * @param string $version
     * @param string $description
     * @param string $revision
     * @param array $authors
     */
    public function __construct(
        public string $version = '',
        public string $description = '',
        public string $revision = '',
        public array  $authors = [],
    )
    {
        $path = dirname(getcwd()) . '/composer.json';
        if (file_exists($path)) {
            $composer = json_decode(file_get_contents($path), true);
            $this->version = $composer['version'];
            $this->description = $composer['description'];
            $this->revision = $composer['revision'];
            $this->authors = $composer['authors'];
        }
    }

}
