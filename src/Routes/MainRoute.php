<?php

namespace Teapodsoft\Routes;

use Teapodsoft\Base\RouteAbstract;
use OpenApi\Attributes as OA;
use Teapodsoft\Helpers\ScriptInfo;
use Teapodsoft\Responses\ResponseDTO;

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
