<?php

namespace Teapodsoft\Applications\Middlewares;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

/**
 * @package Teaposoft\Applications\Middlewares
 * @description Обработчик Middleware для работы с Json ответом
 */
final class ResponseJsonMiddleware implements MiddlewareInterface
{

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        return $response->withHeader('Content-Type', 'application/json');
    }

}
