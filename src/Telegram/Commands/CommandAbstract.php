<?php

namespace Teapodsoft\Telegram\Commands;

use Closure;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;

/**
 *
 */
abstract class CommandAbstract implements CommandInterface
{

    /**
     * @param Client $bot
     * @return Closure
     */
    public static function use(Client $bot): Closure
    {
        return function (Message $message) use ($bot) {
            /** @var BotApi $bot */
            $bot->sendMessage(
                chatId: $message->getChat()->getId(),
                text: static::getMessage(),
            );
        };
    }

    /**
     * @return string
     */
    abstract protected static function getMessage(): string;

}
