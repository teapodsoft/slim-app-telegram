# Описание

Основные параметры для работы, к которым можно отнести

- Настройка секретов
- Настройка параметров приложение
- Настройка docker-compose

# Подготовка

Для корректной работы приложения требуется настроить секреты и параметры приложения для работы.

## Настройка секретов

Требуется выполнить следующую команду:

```shell
cp secrets/secrets.example.json secrets/secrets.json
```

## Настройка параметры приложения

Требуется выполнить следующую команду:

```shell
cp .env.dist .env 
```

## Настройка параметров docker для корректного запуска

Для корректной работы всех компонентов потребуется настроить .env файл. В зависимости от необходимых компонентов
требуется раскомментировать необходимый блок.

```dotenv
# PHP + MySQL + Memcached
#COMPOSE_FILE=docker-compose.yml:docker-compose.mysql.yml:docker-compose.memcached.yml

# PHP + Mysql 
#COMPOSE_FILE=docker-compose.yml:docker-compose.mysql.yml

# PHP 
#COMPOSE_FILE=docker-compose.yml
```

# Запуск

Для корректного запуска потребуется использовать команду

Запуск:

```shell
docker compose up -d 
```

Остановка работы:

```shell
docker compose down 
```