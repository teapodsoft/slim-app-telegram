<?php

namespace Teapodsoft\Applications\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 *
 */
final class ResponseJsonMiddleware extends ResponseMiddleware
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $response = parent::process($request, $handler);
        return $response
            ->withHeader('Content-type', 'application/json');
    }

}
