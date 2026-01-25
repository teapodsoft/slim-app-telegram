<?php

namespace Teapodsoft\Base;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DI\Container;

/**
 *
 */
abstract class RouteAbstract implements RouteInterface
{

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response
     */
    protected Response $response;


    /**
     * @param Container $container
     */
    public function __construct(
        protected Container $container
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
        $this->request = $request;
        $this->response = $response;

        $content = $this->run();
        if (is_array($content)) {
            $content = json_encode($content);
        }

        $response->getBody()->write($content);
        return $response;
    }

    /**
     * @return mixed
     */
    abstract public function run(): mixed;

}
