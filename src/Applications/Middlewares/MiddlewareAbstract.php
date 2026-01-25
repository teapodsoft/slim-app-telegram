<?php

namespace Teapodsoft\Applications\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

abstract class MiddlewareAbstract implements Middleware
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    abstract public function process(Request $request, RequestHandler $handler): Response;

}
