# testprh-apple

* Проект реализован с использованием Docker

## Install

Clone repo

```
$ git clone https://github.com/merinovroman/testprh-apple.git
```

Запуск Docker
```
$ cd ./docker-prh
$ docker-compose build
$ docker-compose up
```

зайти в php-cli для сборки b маграции:
```
$ cd ./docker-prh
$ docker-compose exec prh-php-cli /bin/bash
$ composer update
$ php ./yii migrate
```

## Доступы
Заходим на фронтенд и регистрируем пользователя:
* <http://localhost/frontend/web/index.php?r=site%2Fsignup>

Переходим в бекэнд и авторизуемся:
* <http://localhost/backend/web/index.php?r=apple%2Findex>


