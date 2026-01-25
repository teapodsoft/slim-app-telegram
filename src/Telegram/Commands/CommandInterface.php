<?php

namespace Teapodsoft\Telegram\Commands;

use TelegramBot\Api\Client;
use Closure;

/**
 *
 */
interface CommandInterface
{

    /**
     * @param Client $bot
     * @return Closure
     */
    public static function use(Client $bot): Closure;

}
