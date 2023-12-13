# Тестовое задание на создание REST API

![PHP Version](https://img.shields.io/badge/php-%5E8.2-7A86B8)
![MySQL Version](https://img.shields.io/badge/mysql-latest-F29221)
![Laravel Version](https://img.shields.io/badge/laravel-%5E10.10-F13C30)

## Начало работы

Чтобы развернуть проект локально или на хостинге, выполните последовательно несколько действий:

1. Клонируйте репозиторий:

```bash
git clone git@github.com:kiipod/1622797-test-restapi-1.git test
```

2. Перейдите в директорию проекта:

```bash
cd test
```

3. Установите зависимости, выполнив команду:

```bash
composer install
```

4. Затем создайте файл .env:

```bash
cp .env.example .env
```

И пропишите в нем настройки, соответствующие вашему окружению.

5. После этого сгенерируйте ключ приложения:

```bash
php artisan key:generate
```

6. Для генерации JWT Secret Key выполните команду:

```bash
php artisan jwt:secret
```

7. Запустите Docker для дальнейшей работы командой:

```bash
./vendor/bin/sail up
```

8. Запустите миграции:

```bash
./vendor/bin/sail artisan migrate
```

9. Заполните БД сидированными данными (по желанию):

```bash
./vendor/bin/sail artisan db:seed
```

10. Для запуска статического анализатора кода выполните команду:

```bash
php artisan insights
```

## Техническое задание
[Посмотреть техническое задание проекта](tz.md)
