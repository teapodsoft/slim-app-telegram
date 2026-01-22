<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Slim\Factory\ServerRequestCreatorFactory;
use Teapodsoft\Applications\Settings\SettingsInterface;
use Teapodsoft\Applications\ResponseEmitter\ResponseEmitter;
use Teapodsoft\Env;

require_once dirname(__DIR__) . '/vendor/autoload.php';

Env::load(dirname(__DIR__), '.env');

// Собираем всё из configs директории для работы
$containerBuilder = new ContainerBuilder();

// Загрузка настроек в приложение
$settings = require dirname(__DIR__) . '/configs/settings.php';
$settings($containerBuilder);

// Загрузка все репозиториев (entity) для работы (базы и прочее)
$repositories = require dirname(__DIR__) . '/configs/repositories.php';
$repositories($containerBuilder);

// Собираем контейнер и отдаем внутри Slim App
$container = $containerBuilder->build();
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Регистрируем все middleware установка (beforeAction и afterAction)
$middleware = require dirname(__DIR__) . '/configs/middlewares.php';
$middleware($app);

// Настраиваем все ссылки и обработчики, которые будут использовать в приложении
$routes = require dirname(__DIR__) . '/configs/routes.php';
$routes($app);

// Запускаем и прописываем все настройки
$settings = $container->get(SettingsInterface::class);
$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Региструем middleware для работы с ошибками
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);

// Запуск обработчика для всех Request запросов
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
