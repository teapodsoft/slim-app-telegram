<?php

namespace Teapodsoft\Actions;

use Psr\Container\ContainerInterface as Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Action
 *
 * @package Teapodsoft\Actions
 * @description Абстрактный класс обработки действий для Routes
 */
abstract class Action implements InterfaceAction
{

    /**
     * @param Container $container
     */
    public function __construct(
        private Container $container
    )
    {
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        return $response;
    }

    /**
     * @param array $data
     * @return false|string
     */
    protected function json(array $data): false|string
    {
        return json_encode($data);
    }

}
