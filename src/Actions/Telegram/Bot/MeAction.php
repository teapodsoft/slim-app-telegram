<?php

namespace Teapodsoft\Actions\Telegram\Bot;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Teapodsoft\Actions\Action;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;
use OpenApi\Attributes as OA;

/**
 * MeAction
 *
 * @package Teapodsoft\Actions\Telegram
 * @description Класс для работы с методом /me для Telegram
 */
final class MeAction extends Action
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
        path: '/bot/me',
        description: 'Telegram Bot information',
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
    )]
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $botApi = $this->getBotApi();
        $response->getBody()->write($this->json([
            'me' => $botApi->getMe(),
        ]));

        return parent::__invoke($request, $response, $args);
    }

}
