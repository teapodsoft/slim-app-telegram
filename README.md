# Teapodsoft Slim Telegram Bot Application

Основная задача данного проекта - предоставить разработчику возможность легко и быстро запустить бота для работы с
Telegram.

# Требования

- Хостинг с поддержкой PHP 8.4 или выше и Apache
- SSL сертификат для домена (подойдет и Let's encrypt)

# Структура проекта

Приложение построено по следующей структуре:

```
configs/                    Файлы настроек приложения  
docker/                     Директория для создания образа Docker        
public/                     Основная директория работы приложения
    index.php               Основной файл для работы приложения 
secrets/                    Директория с секретными данными для работы окружения
src/                        Исходный код приложения
    Actions/                Диреткория для обработчиков ссылок
        Swagger/            Директория для работы со Swagger
        Telegram/           Директория дял работы с Telegram Bot API ссылками
    Applications/           Директория с проектом и необходимым настройками
        ResponseEmiter/     Директория с обработчиками Response запросов
        Settings/           Директория с настройками и обработчиками
    Composer/               Директория для работы с Composer и действия postInstall событиями
    Middlewares/            Обработчики событый между Request и Response 
    Telegram/               Обработчики для Telegram 
        Commands/           Обработчики команд для Telegram
tests/                      Тесты для проверки работоспособности
vendor/                     Директория с установленными Composer пакетами
```

# Установка

## Установка локально для последующей загрузки на хостинг

Для того, что бы установить приложение и загрузить итоговый вариант на хостинг потребуется
наличие [Docker](https://www.docker.com/) на локальном месте и
дополнения [Docker Compose](https://docs.docker.com/compose/).

### Подготовка проекта к работе

Для локального разворота потребуется настроить файл .env. Для этого скопируйте шаблонный .env.dist через команду

```shell
cp .env.dist .env
```

Для разворота используйте команду и дождитесь итоговой сборки:

```shell
docker compose up -d 
```

## Установка с использованием Composer на хостинге

Если у вас нет [Composer](https://getcomposer.org/), вы можете использовать инструкцию с
сайта [getcomposer.org](https://getcomposer.org/doc/00-intro.md).

Создание проекта:

```shell
composer create-project teapodsoft/slim-app-telegram myproject
cd myproject
```

# Настройка проекта

Для корректной настройки приложения вам потребуется настроить файл secrets.json, который находится в директории secrets.

В случае, если после установки приложения у вас не создался файл secrets.json, то требуется использовать команду

```shell
cp secrets/secrets.example.json secrets/secrets.json 
```

Структура secrets.json

```jsonpath
{
    "project": {
        // Наименование вашего приложения
        "NAME": "Basic Template Bot API",
        // Полная ссылка на домен, который будет использоватсья для /webhook условий
        "DOMAIN": "https://bots.my-domain.ltd"
    },
    "telegram": {
        // Токен, полученный от BotFather
        "TOKEN": "ТОКЕН от BotFather"
    }
}

```

# Работа с Telegram Bot Webhook

## Установка webhook

В рамках использования подхода webhook требуется отправить запрос в Telegram Bot API с указанием ссылки, на которую
будут отправляться запросы, когда пользователи пишут боту. Для этого, после разворота требуется открыть в браузере
ссылку http://bots.my-domain.ltd/hook/set

В ответ вы получите результат, что webhook установлен:

```json
{
    "setWebhook": true
}
```

## Проверка текущего состояния

Для проверки установленного webhook можете воспользоваться ссылкой https://bots.my-domain.ltd/hook/get

В ответ вы получите результат с информацией об установке:

```json
{
    "hook": {
        "url": "https://bots.my-domain.ltd/webhook",
        "has_custom_certificate": false,
        "pending_update_count": 0,
        "ip_address": "1.1.1.1",
        "max_connections": 40
    }
}
```

## Удаление установленного webhook

В случае если вам требуется удалить привязку Telegram бота от webhook - воспользуйтесь
ссылкой https://bots.my-domain.ltd/hook/delete

В ответ вы получите результат

```json
{
    "hook": "true"
}
```

## Работа со Swagger

Приложение поддерживает Swagger. Вы можете получить список всех доступных для работы ссылок, обратившись по
ссылке https://bots.my-domain.ltd/json-schema

# Настройка своих команд для Telegram Bot

Для того, что бы настроить свои команды для работы потребуется

- Создать класс в директории /src/Telegram/Commands
- Наследовать ваш класс от абстрактного класса Command
- Добавить все необходимые функции для работы

Пример класса:

```php
<?php

namespace Teapodsoft\Telegram\Commands;

final class TimeCommand extends Command
{

    protected static function returnMessage(): string
    {
        return 'Current Time: '. date('Y-m-d H:i:s', time());
    }

}
```

После проделанных действий требуется включить команду в список доступных для бота. Для этого требуется в файле
configs/bot_settings.php добавить в список ваш класс для работы:

Пример настроек:

```php
<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Teapodsoft\Telegram\Commands\InterfaceCommand;
use Teapodsoft\Telegram\Commands\StartCommand;
use Teapodsoft\Telegram\Commands\DemoCommand;
use Teapodsoft\Telegram\Commands\TimeCommand;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        InterfaceCommand::class => function () {
            return [
                'start' => StartCommand::class,
                'demo' => DemoCommand::class,
                'time' => TimeCommand::class,
                'date' => TimeCommand::class,
            ];
        }
    ]);
};

```
