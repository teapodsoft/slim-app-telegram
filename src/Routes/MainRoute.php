<?php

namespace Teapodsoft\Routes;

use Teapodsoft\{Base\RouteAbstract, Helpers\ScriptInfo};

/**
 * @package Teaposoft\Routes
 * @description Обработчик Routes "/"
 */
final class MainRoute extends RouteAbstract
{

    /**
     * @return array
     */
    public function run(): array
    {
        $scriptInfo = new ScriptInfo();
        return [
            'version' => $scriptInfo->version,
            'revision' => $scriptInfo->revision,
            'description' => $scriptInfo->description,
        ];
    }

}
