[Задание](https://docs.google.com/document/d/1WNDPzGEs-zgsTvoQ6KS3KyP4F_7il94_DWujKc0PkJ0)

Докер-контейнер для Yii2 с MySQL взят из [xzag/yii2-docker-basic](https://github.com/xzag/yii2-docker-basic)
## Запуск
Открыть проект.
```bash
cd docker # зайти в папку "docker" внутри проекта
```

```bash
docker-compose build # сборка контейнера
```

```bash
docker-compose up -d # запуск
```

```bash
docker-compose exec php composer install --ignore-platform-reqs # установка зависимостей composer 
```

```bash
docker-compose exec php php yii migrate # выполнение миграций
```

Далее необходимо подключиться к БД, развернутой в докере и загрузить [дамп](https://drive.google.com/file/d/17rtEMYRsfYkibMtGBzCQleaVwrRAXilQ/view?usp=sharing) с данными в БД.

Сервер: `localhost` </br>
Порт: `3306` </br>
Имя БД:`dbname` </br>
Имя пользователя: `username` </br>
Пароль: `password` </br>

Страница со списком заказов:
[http://localhost/index.php?r=orders](http://localhost/index.php?r=orders)
