<?php

namespace Teapodsoft\Actions\Swagger;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Teapodsoft\Actions\Action;
use OpenApi\Attributes as OA;
use OpenApi\Generator;

/**
 * SwaggerAction
 *
 * @package Teapodsoft\Actions\Swagger
 * @description Класс для генерации JSON для Swagger
 */
#[OA\Info(
    version: '1.0',
    title: 'TelegramBot Application Swagger API'
)]
final class SwaggerAction extends Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    #[OA\Get(
        path: '/json-schema',
        description: 'Swagger JSON Schema'
    )]
    #[OA\Response(
        response: 200,
        description: 'JSON Schema for Swagger UI'
    )]
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/src/Actions';
        $swagger = new Generator()->generate([$path]);
        $response->getBody()->write($swagger->toJson());
        return parent::__invoke($request, $response, $args);
    }

}
