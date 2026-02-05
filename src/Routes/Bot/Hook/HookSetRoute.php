<?php

namespace Teapodsoft\Routes\Bot\Hook;

use DI\{DependencyException, NotFoundException};
use OpenApi\Attributes as OA;
use Teapodsoft\Applications\Interfaces\BotApiInterface;
use Teapodsoft\Base\RouteAbstract;
use Teapodsoft\Secrets;
use TelegramBot\Api\{BotApi, Exception};

/**
 * @package Teapodsoft\Routes\Bot\Hook
 * @description Обработчик Routes "/bot/hook/set"
 */
final class HookSetRoute extends RouteAbstract
{


    /**
     * @throws Exception
     * @throws DependencyException
     * @throws NotFoundException
     */
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

        /** @var BotApi $bot */
        $bot = $this->container->get(BotApiInterface::class);

        $webhookUrl = Secrets::get('DOMAIN', '', 'project');
        $data['webhook'] = $webhookUrl;

        $result = $bot->setWebhook($webhookUrl . '/webhook');
        $data['result'] = $result;

        return $data;
    }

}
