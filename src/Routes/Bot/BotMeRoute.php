<?php

namespace Teapodsoft\Routes\Bot;

use Teapodsoft\Base\RouteAbstract;
use OpenApi\Attributes as OA;
use Teapodsoft\Telegram\BotApiInterface;
use TelegramBot\Api\BotApi;

/**
 *
 */
final class BotMeRoute extends RouteAbstract
{

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
    public function run(): array|string
    {
        $data = [];
        try {
            /** @var BotApi $bot */
            $bot = $this->container->get(BotApiInterface::class);
            $data = $bot->getMe()->toJson(true);
        } catch (\Throwable $exception) {
            $this->response->withStatus(500);
            $data['exception'] = $exception->getMessage();
        }

        return $data;
    }

}
