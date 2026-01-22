<?php

namespace Teapodsoft\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * InterfaceAction
 *
 * @package Teapodsoft\Actions
 * @description Интерфейс для работы со всеми Action
 */
interface InterfaceAction
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response;

}
