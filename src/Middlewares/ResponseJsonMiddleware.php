<?php

namespace Teapodsoft\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * ResponseJsonMiddleware
 *
 * @package Teapodsoft\Middleware
 * @description Обработка результата, чтобы передавались только JSON ответы
 */
class ResponseJsonMiddleware implements Middleware
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
