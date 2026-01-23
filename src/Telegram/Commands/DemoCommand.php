<?php

namespace Teapodsoft\Telegram\Commands;

/**
 * DemoCommand
 *
 * @package Teapodsoft\Telegram\Commands
 * @description Обработка команды /demo
 */
final class DemoCommand extends Command
{

    /**
     * @return string
     */
    protected static function returnMessage(): string
    {
        return 'This is /demo command from DemoCommand';
    }


}
