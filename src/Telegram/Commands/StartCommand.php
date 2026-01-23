<?php

namespace Teapodsoft\Telegram\Commands;

/**
 * StartCommand
 *
 * @package Teapodsoft\Telegram\Commands
 * @description Обработка команды /start
 */
final class StartCommand extends Command
{

    /**
     * @return string
     */
    protected static function returnMessage(): string
    {
        return 'This is /start command from StartCommand class';
    }

}
