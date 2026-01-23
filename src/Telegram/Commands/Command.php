<?php

namespace Teapodsoft\Telegram\Commands;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use Closure;
use TelegramBot\Api\Types\Message;

/**
 * Command
 *
 * @package Teapodsoft\Telegram\Commands
 * @description Абстрактный класс для работы с командами бота
 */
abstract class Command implements InterfaceCommand
{

    public static function use(Client $bot): Closure
    {
        return function (Message $message) use ($bot) {
            /** @var BotApi $bot */
            $bot->sendMessage(
                chatId: $message->getChat()->getId(),
                text: static::returnMessage(),
            );
        };
    }


    /**
     * @return string
     */
    abstract protected static function returnMessage(): string;

}
