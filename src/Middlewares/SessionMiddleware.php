<?php

namespace Teapodsoft\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * SessionMiddleware
 *
 * @package Teapodsoft\Middlewares
 * @description Обработчик для работы с сессией
 */
class SessionMiddleware implements Middleware
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            session_start();
            $request = $request->withAttribute("session", $_SESSION);
        }

        return $handler->handle($request);
    }

}
