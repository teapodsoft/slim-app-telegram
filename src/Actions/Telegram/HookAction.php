<?php

namespace Teapodsoft\Actions\Telegram;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Teapodsoft\Telegram\Commands\InterfaceCommand;
use Teapodsoft\Actions\Action;
use TelegramBot\Api\Types\Update;
use TelegramBot\Api\BotApi;

/**
 * HookAction
 *
 * @package Teapodsoft\Actions\Telegram
 * @description Класс для обработки запросов '/hook', которые относятся к Telegram Bot WebHook
 */
final class HookAction extends Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @comment Сюда не добавляем логику Swagger API, потому что смысл отдавать наружу информацию о работе с ботом ?
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = [];

        try {
            $bot = $this->getBotClient();

            $commands = $this->getTelegramCommands() ?? [];
            if (!empty($commands)) {
                // Бежим по массиву и стараемся всё отдать в бота, что бы он использовал классы от InterfaceCommand
                foreach ($commands as $command => $commandClass) {

                    /** @var string $command */
                    /** @var InterfaceCommand $commandClass */
                    $bot->command($command, $commandClass::use($bot));
                }
                // Если нет команд, то бот отвечает, что он сейчас ничего не умеет
            } else {
                $bot->on(function (Update $update) use ($bot) {
                    $message = $update->getMessage();

                    /** @var BotApi $bot */
                    $bot->sendMessage(
                        chatId: $message->getChat()->getId(),
                        text: 'Sorry, but bot do not have any commands. Please stand by for more news'
                    );
                });
            }

            $bot->run();
        } catch (\Throwable $exception) {
            $data['error'] = $exception->getMessage();
        }

        $response->getBody()->write($this->json($data));
        return parent::__invoke($request, $response, $args);
    }

}
