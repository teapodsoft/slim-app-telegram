<?php

namespace Teapodsoft\Applications\Interfaces;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * @package Teaposoft\Applications\Interface
 * @description Интерфейс для работы с Route логикой приложения
 */
interface RouteInterface
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface;

}
