<?php

namespace Teapodsoft\Telegram\Commands;

/**
 * StartCommand
 *
 * @package Teapodsoft\Telegram\Commands
 * @description Обработка команды /start
 */
final class StartCommand extends CommandAbstract
{

    /**
     * @return string
     */
    protected static function getMessage(): string
    {
        return 'This is /start command from StartCommand class';
    }

}
