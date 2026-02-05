<?php

namespace Teapodsoft\Routes;

use DI\{DependencyException, NotFoundException};
use Teapodsoft\Applications\Interfaces\BotClientInterface;
use Teapodsoft\Applications\Interfaces\CommandInterface;
use Teapodsoft\Base\RouteAbstract;
use TelegramBot\Api\{BotApi, Client, InvalidJsonException, Types\Update};

/**
 * @package Teaposoft\Routes
 * @description Обработчик Routes "/bot/webhook'
 */
final class WebhookRoute extends RouteAbstract
{

    /**
     * @return array
     * @throws DependencyException
     * @throws NotFoundException
     * @throws InvalidJsonException
     */
    public function run(): array
    {
        $data = [];
        /** @var Client $bot */
        $bot = $this->container->get(BotClientInterface::class);

        /** @var array $commands */
        $commands = $this->container->get(CommandInterface::class);
        if (empty($commands)) {
            $bot->on(function (Update $update) use ($bot) {
                /** @var BotApi $bot */
                $message = $update->getMessage();
                $bot->sendMessage(
                    chatId: $message->getChat()->getId(),
                    text: 'Sorry, but bot do not have any commands.'
                );
            });
        } else {
            foreach ($commands as $command => $commandClass) {
                /** @var string $command */
                /** @var CommandInterface $commandClass */
                $bot->command($command, $commandClass::use($bot));
            }
        }

        $bot->run();

        return $data;
    }

}
