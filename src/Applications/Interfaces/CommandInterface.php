<?php

namespace Teapodsoft\Applications\Interfaces;

use Closure;
use TelegramBot\Api\Client;

/**
 * @package Teaposoft\Applications\Interfaces
 * @description Интерфейс для работы с Telegram Bot
 */
interface CommandInterface
{

    /**
     * @param Client $bot
     * @return Closure
     */
    public static function use(Client $bot): Closure;

}
