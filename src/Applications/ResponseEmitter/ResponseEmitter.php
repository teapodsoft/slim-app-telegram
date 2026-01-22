<?php

namespace Teapodsoft\Applications\ResponseEmitter;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\ResponseEmitter as SlimResponseEmitter;

/**
 * ResponseEmitter
 *
 * @package Teapodsoft\Application\ResponseEmitter
 * @description Класс для работы с заголовками
 */
class ResponseEmitter extends SlimResponseEmitter
{

    /**
     * @param Response $response
     * @return void
     */
    public function emit(Response $response): void
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        $response = $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader(
                'Access-Control-Allow-Headers',
                'X-Requested-With, Content-Type, Accept, Origin, Authorization'
            )
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->withAddedHeader('Cache-Control', 'post-check=0, pre-check=0')
            ->withHeader('Pragma', 'no-cache');

        if (ob_get_contents()) {
            ob_clean();
        }

        parent::emit($response);
    }

}
