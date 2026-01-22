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
 * GetUpdateAction
 *
 * @package Teapodsoft\Actions\Telegram
 * @description Обработа результата /update
 */
final class GetUpdateAction extends Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    #[OA\Get(
        path: '/bot/update',
        description: 'Get Messages from bot storage'
    )]
    #[OA\Response(
        response: 200,
        description: 'Get messages from bot storage',
    )]
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = [];
        try {
            $botApi = $this->getBotApi();
            $updates = [];
            foreach ($botApi->getUpdates() as $update) {
                $updates[] = json_decode($update->toJson(), true);
            }
            $data['updates'] = $updates;
        } catch (\Throwable $exception) {
            $data['exception'] = $exception->getMessage();
        }

        $response->getBody()->write($this->json($data));

        return parent::__invoke($request, $response, $args);
    }

}
