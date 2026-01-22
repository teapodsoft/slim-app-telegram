<?php

namespace Teapodsoft\Actions\Telegram\Hook;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Teapodsoft\Actions\Action;
use OpenApi\Attributes as OA;
use Teapodsoft\Secrets;
use TelegramBot\Api\Exception;

/**
 * HookSetAction
 *
 * @package Teapodsoft\Actions\Telegram\Hook
 * @description Установить определенные настройки в роли webhook для Telegram Bot
 */
final class HookSetAction extends Action
{


    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[OA\Get(
        path: '/bot/hook/set',
        description: 'Install current domain as webhook for Telegram Bot'
    )]
    #[OA\Response(
        response: 200,
        description: "Get current status for Telegram Bot webhook installation",
    )]
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        // Берем из secrets параметр project.DOMAIN и добавляем к нему /hook, что бы использовать как хук для работы бота
        $currentDomain = Secrets::get('DOMAIN', 'https://localhost', 'project');
        $botApi = $this->getBotApi();

        $response->getBody()->write($this->json([
            'setWebhook' => $botApi->setWebhook($currentDomain . '/webhook')
        ]));
        return parent::__invoke($request, $response, $args);
    }
}
