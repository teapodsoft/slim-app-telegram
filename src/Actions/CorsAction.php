<?php

namespace Teapodsoft\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * CorsAction
 *
 * @package Teapodsoft\Actions
 * @description Класс для работы с Options для CORS
 */
final class CorsAction extends Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        //TODO: Добавить сюда свою логику работы с CORS
        return parent::__invoke($request, $response, $args);
    }

}
