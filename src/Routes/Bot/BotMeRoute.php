<?php

namespace Teapodsoft\Routes\Bot;

use DI\{DependencyException, NotFoundException};
use OpenApi\Attributes as OA;
use Teapodsoft\Applications\Interfaces\BotApiInterface;
use Teapodsoft\Base\RouteAbstract;
use TelegramBot\Api\{BotApi, Exception, InvalidArgumentException};

/**
 * @package Teaposoft\Routes\Bot
 * @description Обработчик Routes "/bot/me"
 */
final class BotMeRoute extends RouteAbstract
{

    /**
     * @return array
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[OA\Get(
        path: '/bot/me',
        description: 'Get Telegram Bot information',
        tags: ['Telegram', 'Bot']
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'first_name', type: 'string'),
                new OA\Property(property: 'username', type: 'string'),
                new OA\Property(property: 'can_join_groups', type: 'boolean'),
                new OA\Property(property: 'can_read_all_group_messages', type: 'boolean'),
                new OA\Property(property: 'supports_inline_queries', type: 'boolean'),
                new OA\Property(property: 'is_bot', type: 'boolean'),
            ],
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
        return $bot->getMe()->toJson(true);
    }

}
