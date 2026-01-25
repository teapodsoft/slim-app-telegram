<?php

namespace Teapodsoft\Routes\Bot\Hook;

use Teapodsoft\Base\RouteAbstract;
use OpenApi\Attributes as OA;
use Teapodsoft\Telegram\BotApiInterface;
use TelegramBot\Api\BotApi;

/**
 *
 */
final class HookDeleteRoute extends RouteAbstract
{

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
        try {
            /** @var BotApi $bot */
            $bot = $this->container->get(BotApiInterface::class);
            $data['result'] = $bot->deleteWebhook();
        } catch (\Throwable $exception) {
            $this->response->withStatus(500);
            $data['exception'] = $exception->getMessage();
        }
        return $data;
    }

}
