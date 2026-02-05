<?php

namespace Teapodsoft\Applications\Handlers;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Slim\App;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

/**
 * @package Teapodsoft\Applications\Handlers
 * @description Обработчик JSON ответа при ошибки
 */
readonly class ErrorJsonHandler implements ErrorHandlerInterface
{

    /**
     * @param App $app
     */
    public function __construct(
        private App $app,
    )
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @param Throwable $exception
     * @param bool $displayErrorDetails
     * @param bool $logErrors
     * @param bool $logErrorDetails
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails): ResponseInterface
    {
        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()
            ->write(json_encode([
                'exception' => $exception->getMessage(),
            ]));
        return $response;
    }
}
