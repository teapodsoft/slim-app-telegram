<?php

namespace Teapodsoft\Actions\Telegram\Hook;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Teapodsoft\Actions\Action;
use OpenApi\Attributes as OA;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

/**
 * HookGetAction
 *
 * @package Teapodsoft\Actions\Telegram\Hook
 * @description Получить текущее состояние по установленному webhook у бота
 */
final class HookGetAction extends Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[OA\Get(
        path: '/hook/get',
        description: 'Get current webhook from Telegram Bot',
    )]
    #[OA\Response(
        response: 200,
        description: 'Get current webhook Telegram Bot',
        //TODO: Добавить сюда более точную информацию по методу $botApi->getWebhookInfo() в виде структуры
    )]
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {

        $botApi = $this->getBotApi();

        $currentWebhook = $botApi->getWebhookInfo();
        $response->getBody()->write($this->json([
            'hook' => json_decode($currentWebhook->toJson(), true),
        ]));
        return parent::__invoke($request, $response, $args);
    }
}
