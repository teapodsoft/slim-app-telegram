<?php

namespace Teapodsoft\Base;

use DI\Container;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Teapodsoft\Applications\Interfaces\RouteInterface;

/**
 * @package Teapodsoft\Base
 * @description Абстрактный класс для работы со всеми Route схемами из директории /src/Routes
 */
abstract class RouteAbstract implements RouteInterface
{

    /**
     * @var ServerRequestInterface
     */
    protected ServerRequestInterface $request;

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @var array
     */
    protected array $args = [];

    /**
     * @param Container $container
     */
    public function __construct(
        protected Container $container
    )
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

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
