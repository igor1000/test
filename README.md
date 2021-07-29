Для работы сайта выполнить команды:

1. docker-compose up -d --build
2. docker-compose run --rm manager-php-cli composer install
2. зайти в контейнер docker-compose exec test-php-fpm /bin/bash
3. php bin/console doctrine:database:create
4. php bin/console doctrine:migrations:migrate
5. php bin/console doctrine:fixtures:load

Сайт доступен по адресу: http://localhost:8080
Редактор MySQL: http://localhost:8081. Пользователь: root, пароль: secret