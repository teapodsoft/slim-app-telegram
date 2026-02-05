<?php

namespace Teapodsoft\Routes\Bot\Hook;

use DI\{DependencyException, NotFoundException};
use OpenApi\Attributes as OA;
use Teapodsoft\{Base\RouteAbstract, Applications\Interfaces\BotApiInterface};
use TelegramBot\Api\{BotApi, Exception};

/**
 * @package Teapodsoft\Routes\Bot\Hook
 * @description Обработчик Routes "/bot/hook/delete"
 */
final class HookDeleteRoute extends RouteAbstract
{

    /**
     * @return array
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[OA\Get(
        path: '/bot/hook/delete',
        description: 'Delete installed webhook',
        tags: ['Telegram', 'Bot', 'Webhook']
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'result', type: 'boolean'),
            ]
        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Exception',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'exception', type: 'string'),
            ]
        )
    )]
    public function run(): array
    {
        $data = [];
        /** @var BotApi $bot */
        $bot = $this->container->get(BotApiInterface::class);
        $data['result'] = $bot->deleteWebhook();
        return $data;
    }

}
