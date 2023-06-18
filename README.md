# squid-proxy-with-ssl


## Установка:

```bash
git clone https://github.com/skyBodrik/squid-proxy-with-ssl.git squid-proxy
```
```bash
chmod -R 777 ./squid-proxy
```
```bash
cd ./squid-proxy
```

// Тут нужно создать файл .env с настройками, для примера используйте .env.example

```bash
apt install docker-compose composer
```

В файле docker-compose.yml установите собственне SERVER_SQUID_HOST и SERVER_NAME_PREFIX

Запускаем контейнеры

```bash
docker-compose up -d --build
```

Далее выполняем интсрукции, если запускаем впервые:
```bash
docker exec -it squid-proxy_php_1 bash
```

```bash
composer install
```

```bash
php artisan migrate:install
```

```bash
php artisan migrate
```

```bash
php artisan cache:clear
```

```bash
php artisan backpack:user
```