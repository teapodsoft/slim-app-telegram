<?php

namespace Teapodsoft\Routes;

use Teapodsoft\Applications\SwaggerInterface;
use Teapodsoft\Base\RouteAbstract;
use OpenApi\Attributes as OA;
use OpenApi\Generator;

/**
 *
 */
#[OA\Info(
    version: '1.0.0',
    title: 'Telegram Bot Application Swagger API'
)]
final class SwaggerRoute extends RouteAbstract
{

    #[OA\Get(
        path: '/json-schema',
        description: 'Get Swagger JSON schema',
        tags: ['Swagger']
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
    )]
    public function run(): string
    {
        try {
            $swaggerRoutes = $this->container->get(SwaggerInterface::class);
        } catch (\Throwable) {
            $swaggerRoutes = [];
        }

        $swaggerApi = new Generator()->generate($swaggerRoutes);
        return $swaggerApi->toJson();
    }
}
