<?php

namespace Teapodsoft\Applications;

use DI\ContainerBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Teapodsoft\Applications\Middlewares\MiddlewareAbstract;
use Teapodsoft\Applications\ResponseEmitter\ResponseEmitter;
use Teapodsoft\Applications\Settings\Settings;
use Teapodsoft\Applications\Settings\SettingsInterface;
use Teapodsoft\Routes\SwaggerRoute;
use Teapodsoft\Secrets;
use Teapodsoft\Telegram\BotApiInterface;
use Teapodsoft\Telegram\BotClientInterface;
use Teapodsoft\Telegram\Commands\CommandInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;

/**
 *
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

    public function __construct(
        protected array $config = [],
        protected       $routes,
    )
    {
        $this->container = new ContainerBuilder();
        $this->container->addDefinitions([
            // Регистрация настроек
            SettingsInterface::class => function () {
                return new Settings(
                    settings: $this->config[SettingsInterface::class] ?? []
                );
            },

            // Регистрация команд для Telegram Bot
            CommandInterface::class => function () {
                return $this->config[CommandInterface::class];
            },

            // Регистрируем класс для работы с Telegram Bot Api классом
            BotApiInterface::class => function () {
                return new BotApi(Secrets::get('TOKEN', '', 'telegram'));
            },

            // Регистриуем класс для работы с Telegram Bot Client классом
            BotClientInterface::class => function () {
                return new Client(Secrets::get('TOKEN', '', 'telegram'));
            },

            // Регистрируем директории, которые будем сканировать для использования Swagger
            SwaggerInterface::class => function () {
                return $this->config[SwaggerInterface::class];
            },
        ]);
    }

    public function run(): void
    {
        // Собираем все зарегистрированные контейнеры и регистрируем в $app
        $container = $this->container->build();
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Регистрация всех ссылок для работы
        $routes = $this->routes;
        $routes($app);

        // Обработка настроек приложения для работы
        $settings = $container->get(SettingsInterface::class);
        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
        $app->addErrorMiddleware(
            displayErrorDetails: $settings->get('displayErrorDetails'),
            logErrors: $settings->get('logErrors'),
            logErrorDetails: $settings->get('logErrorDetails'),
        );

        // Регистрируем Middleware для работы
        if (
            isset($this->config[MiddlewareInterface::class])
            && !empty($this->config[MiddlewareInterface::class])
        ) {
            foreach ($this->config[MiddlewareInterface::class] as $middlewareClass) {
                $app->add($middlewareClass);
            }
        }

        new ResponseEmitter()->emit(
            $app->handle(
                ServerRequestCreatorFactory::create()->createServerRequestFromGlobals()
            )
        );
    }

}
