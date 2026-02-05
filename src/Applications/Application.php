<?php

namespace Teapodsoft\Applications;

use DI\ContainerBuilder;
use Psr\Http\Server\MiddlewareInterface;
use Slim\App;
use Slim\Factory\{AppFactory, ServerRequestCreatorFactory};
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Middleware\ErrorMiddleware;
use Teapodsoft\Applications\ResponseEmitter\ResponseEmitter;
use Teapodsoft\Env;

/**
 * @package Teapodsoft\Applications
 * @description Структура приложения для работы с Web
 */
final class Application
{

    /**
     * @var ContainerBuilder
     */
    protected ContainerBuilder $container;

    /**
     * @var App
     */
    protected App $app;

    /**
     * @param $routes
     * @param array $config
     */
    public function __construct(
        protected       $routes,
        protected array $config = [],
    )
    {
        $definitions = [];
        $config = $this->config;

        $this->container = new ContainerBuilder();

        // Читаем все настройки и пытаемся их установить для работы внутри приложения
        foreach ($config as $interfaces => $configurations) {
            $definitions[$interfaces] = $configurations;
        }


        $this->container->addDefinitions($definitions);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $app = $this->getApplication();
        $this->setRoutes($app);
        $this->setDefaultMiddlewares($app);
        $this->setConfigMiddlewares($app);

        new ResponseEmitter()->emit(
            $app->handle(
                ServerRequestCreatorFactory::create()->createServerRequestFromGlobals()
            )
        );
    }

    /**
     * Сбор приложения для запуска из переданных в Container структур
     *
     * @return App
     */
    private function getApplication(): App
    {
        try {
            $container = $this->container->build();
            AppFactory::setContainer($container);
        } catch (\Exception) {
        }
        return AppFactory::create();
    }

    /**
     * Регистрация внутри приложения логики обработчиков, Middleware и Handler
     *
     * @param App $app
     * @return void
     */
    private function setDefaultMiddlewares(App $app): void
    {
        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
        $errorMiddleware = $app->addErrorMiddleware(
            displayErrorDetails: Env::get('APP_CONFIG_DISPLAY_ERRORS_DETAILS', true),
            logErrors: Env::get('APP_CONFIG_ERRORS_LOG', true),
            logErrorDetails: Env::get('APP_CONFIG_ERRORS_LOG_DETAILS', true),
        );
        $this->setConfigHandler($app, $errorMiddleware);
    }

    /**
     * Регистрация данных из файла /configs/routes.php
     *
     * @param App $app
     * @return void
     */
    private function setRoutes(App $app): void
    {
        $routes = $this->routes;
        $routes($app);
    }

    /**
     * Регистрация Middleware если он есть
     *
     * @param App $app
     * @return void
     */
    private function setConfigMiddlewares(App $app): void
    {
        $config = $this->config;
        $middlewares = $config[MiddlewareInterface::class] ?? [];

        if (!empty($middlewares) && is_array($middlewares)) {
            foreach ($middlewares as $middleware) {
                $app->add($middleware);
            }
        }
    }

    /**
     * Регистрация ErrorHandler если он есть
     *
     * @param App $app
     * @param ErrorMiddleware $errorMiddleware
     * @return void
     */
    private function setConfigHandler(App $app, ErrorMiddleware $errorMiddleware): void
    {
        $config = $this->config;
        $handler = $config[ErrorHandlerInterface::class] ?? false;
        if ($handler !== false) {
            $handler = new $handler($app);
            $errorMiddleware->setDefaultErrorHandler($handler);
        }
    }

}
