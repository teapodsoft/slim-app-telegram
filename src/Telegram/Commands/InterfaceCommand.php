<?php

namespace Teapodsoft\Telegram\Commands;

use Closure;
use TelegramBot\Api\Client;

/**
 * InterfaceCommand
 *
 * @package Teapodsoft\Telegram\Commands
 * @description Интерфейс для работы с Telegram Bot
 */
interface InterfaceCommand
{

    /**
     * @param Client $bot
     * @return Closure
     */
    public static function use(Client $bot): Closure;

}
