<?php

namespace Teapodsoft\Routes;

use Teapodsoft\Base\RouteAbstract;
use Teapodsoft\Responses\ResponseDTO;
use Teapodsoft\Telegram\BotClientInterface;
use Teapodsoft\Telegram\Commands\CommandInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;

/**
 *
 */
final class WebhookRoute extends RouteAbstract
{

    /**
     * @return array
     */
    public function run(): array
    {
        $data = [];
        try {
            /** @var Client $bot */
            $bot = $this->container->get(BotClientINterface::class);

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
        } catch (\Throwable $exception) {
            $data['exception'] = $exception->getMessage();
        }

        return $data;
    }

}
