<?php

namespace Teapodsoft\Actions;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as Container;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;

/**
 * Action
 *
 * @package Teapodsoft\Actions
 * @description Абстрактный класс обработки действий для Routes
 */
abstract class Action implements InterfaceAction
{

    /**
     * Пишем так, что бы потом была возможность использовать через
     * ```php
     * $this->container
     * ```
     *
     * @param Container $container
     */
    public function __construct(
        protected Container $container
    )
    {
    }

    /**
     * Обработка события, чтобы лишний раз не писать логику внутри каждого configs/routes.php
     * а использовать классовую структуру
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        return $response;
    }

    /**
     * Вернуть json строку для работы с Response
     *
     * @param array $data
     * @return false|string
     */
    protected function json(array $data): false|string
    {
        return json_encode($data);
    }

    /**
     * Получить BotApi класс из configs/repositories.php
     *
     * @return BotApi
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getBotApi(): BotApi
    {
        //TODO: Обезопаститься от @throws
        return $this->container->get('botApi');
    }

    /**
     * Получить Client класс из configs/repositories.php
     *
     * @return Client
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getBotClient(): Client
    {
        //TODO: Обезопаститься от @throws
        return $this->container->get('botClient');
    }

}
