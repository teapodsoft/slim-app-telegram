<?php

namespace Teapodsoft\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Attributes as OA;

/**
 * TestAction
 *
 * @package Teapodsoft\Actions
 * @description Обработчик логики Route '/'
 */
final class TestAction extends Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    #[OA\Get(
        path: '/',
        description: 'Main Application Url',
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
    )]
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $response->getBody()->write($this->json($this->getData()));
        return parent::__invoke($request, $response, $args);
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return [
            'time' => time(),
            'date' => date('Y-m-d H:i:s', time()),
        ];
    }

}
