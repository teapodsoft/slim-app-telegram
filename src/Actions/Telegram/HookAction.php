<?php

namespace Teapodsoft\Actions\Telegram;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Teapodsoft\Actions\Action;
use OpenApi\Annotations as OA;

/**
 * HookAction
 *
 * @package Teapodsoft\Actions\Telegram
 * @description Класс для обработки запросов '/hook', которые относятся к Telegram Bot WebHook
 */
final class HookAction extends Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @comment Сюда не добавляем логику Swagger API, потому что смысл отдавать наружу информацию о работе с ботом ?
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = [];
        try {
            $botApi = $this->getBotApi();
            //TODO: Сюда добавить логику работы с webhook
        } catch (\Throwable $exception) {
            $data['exception'] = $exception->getMessage();
        }

        $response->getBody()->write($this->json($data));
        return parent::__invoke($request, $response, $args);
    }

}
