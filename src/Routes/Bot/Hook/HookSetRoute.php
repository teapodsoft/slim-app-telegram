<?php

namespace Teapodsoft\Routes\Bot\Hook;

use Teapodsoft\Base\RouteAbstract;
use OpenApi\Attributes as OA;
use Teapodsoft\Secrets;
use Teapodsoft\Telegram\BotApiInterface;
use TelegramBot\Api\BotApi;

/**
 *
 */
final class HookSetRoute extends RouteAbstract
{

    #[OA\Get(
        path: '/bot/hook/set',
        description: 'Install current domain as webhook for Telegram Bot',
        tags: ['Telegram', 'Bot', 'Webhook']
    )]
    #[OA\Response(
        response: 200,
        description: 'Telegram Bot webhook set result',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'webhook', type: 'string'),
                new OA\Property(property: 'result', type: 'string'),
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

            $webhookUrl = Secrets::get('DOMAIN', '', 'project');
            $data['webhook'] = $webhookUrl;

            $result = $bot->setWebhook($webhookUrl . '/webhook');
            $data['result'] = $result;
        } catch (\Throwable $exception) {
            $this->response->withStatus(500);
            $data['exception'] = $exception->getMessage();
        }

        return $data;
    }

}
