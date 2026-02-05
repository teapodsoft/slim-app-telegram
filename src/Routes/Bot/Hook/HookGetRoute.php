<?php

namespace Teapodsoft\Routes\Bot\Hook;

use DI\{DependencyException, NotFoundException};
use OpenApi\Attributes as OA;
use Teapodsoft\Applications\Interfaces\BotApiInterface;
use Teapodsoft\Base\RouteAbstract;
use TelegramBot\Api\{BotApi, Exception, InvalidArgumentException};

/**
 * @package Teapodsoft\Routes\Bot\Hook
 * @description Обработчик Routes "/bot/hook/get"
 */
final class HookGetRoute extends RouteAbstract
{

    /**
     * @return array
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[OA\Get(
        path: '/bot/hook/get',
        description: 'Get current installed webhook from Telegram Bot',
        tags: ['Telegram', 'Bot', 'Webhook']
    )]
    #[OA\Response(
        response: 200,
        description: 'Current installed webhook from Telegram Bot',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'url', type: 'string'),
                new OA\Property(property: 'has_custom_certificate', type: 'boolean'),
                new OA\Property(property: 'pending_update_count', type: 'integer'),
                new OA\Property(property: 'ip_address', type: 'string'),
                new OA\Property(property: 'max_connections', type: 'integer'),
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
        /** @var BotApi $bot */
        $bot = $this->container->get(BotApiInterface::class);
        return $bot->getWebhookInfo()->toJson(true);
    }

}
