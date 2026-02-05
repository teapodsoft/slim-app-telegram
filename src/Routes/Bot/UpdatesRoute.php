<?php

namespace Teapodsoft\Routes\Bot;

use DI\{DependencyException, NotFoundException};
use OpenApi\Attributes as OA;
use Teapodsoft\Applications\Interfaces\BotApiInterface;
use Teapodsoft\Base\RouteAbstract;
use TelegramBot\Api\{BotApi, Exception, InvalidArgumentException};

/**
 * @package Teaposoft\Routes\Bot
 * @description Обработчик Routes "/bot/updates"
 */
final class UpdatesRoute extends RouteAbstract
{

    /**
     * @return array
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[OA\Get(
        path: '/bot/updates',
        description: 'Get updates from Telegram Bot API',
        tags: ['Telegram', 'Bot', 'Updates']
    )]
    #[OA\Response(
        response: 200,
        description: 'Updates list from Telegram Bot API',
        content: new OA\JsonContent(
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'update_id', type: 'integer'),
                    new OA\Property(property: 'message', properties: [
                        new OA\Property(property: 'message_id', type: 'integer'),
                        new OA\Property(property: 'from', properties: [
                            new OA\Property(property: 'id', type: 'integer'),
                            new OA\Property(property: 'first_name', type: 'string'),
                            new OA\Property(property: 'last_name', type: 'string'),
                            new OA\Property(property: 'username', type: 'string'),
                            new OA\Property(property: 'language_code', type: 'string'),
                            new OA\Property(property: 'is_bot', type: 'boolean'),
                        ], type: 'object'),
                        new OA\Property(property: 'date', type: 'integer'),
                        new OA\Property(property: 'chat', properties: [
                            new OA\Property(property: 'id', type: 'integer'),
                            new OA\Property(property: 'type', type: 'string'),
                            new OA\Property(property: 'username', type: 'string'),
                            new OA\Property(property: 'first_name', type: 'string'),
                            new OA\Property(property: 'last_name', type: 'string'),
                        ], type: 'object'),
                        new OA\Property(property: 'text', type: 'string'),
                        new OA\Property(property: 'entities', type: 'array', items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'type', type: 'string'),
                                new OA\Property(property: 'offset', type: 'integer'),
                                new OA\Property(property: 'length', type: 'integer'),
                            ],
                        )),
                    ], type: 'object'
                    ),
                ],
            ),
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
        foreach ($bot->getUpdates() as $update) {
            $data[] = $update->toJson(true);
        }
        return $data;
    }

}
