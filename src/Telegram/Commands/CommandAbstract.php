<?php

namespace Teapodsoft\Telegram\Commands;

use Closure;
use Teapodsoft\Applications\Interfaces\CommandInterface;
use TelegramBot\Api\{BotApi, Client, Types\Message};

/**
 * @package Teapodsoft\Telegram\Commands
 * @description Абстрактный класс для работы с приложением. Используется для обработки сообщений по определенным командам
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
