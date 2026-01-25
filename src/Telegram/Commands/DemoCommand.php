<?php

namespace Teapodsoft\Telegram\Commands;

/**
 * DemoCommand
 *
 * @package Teapodsoft\Telegram\Commands
 * @description Обработка команды /demo
 */
final class DemoCommand extends CommandAbstract
{

    /**
     * @return string
     */
    protected static function getMessage(): string
    {
        return 'This is /demo command from DemoCommand';
    }


}
