# Articles REST API

REST API на Laravel для работы со статьями, авторами и категориями.

## Стек

- PHP 8.3+, Laravel 13
- SQLite, Eloquent ORM
- Nested Set (`kalnoy/nestedset`)
- L5-Swagger (OpenAPI)
- PHPUnit, Laravel Pint

## Установка и запуск

```bash
git clone <REPOSITORY_URL>
cd my-project

composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
```

В `.env` указать:

```dotenv
DB_CONNECTION=sqlite
```

Создание БД и генерация тестовых данных:

```bash
php artisan migrate --seed
```

Генерация Swagger и запуск сервера:

```bash
php artisan l5-swagger:generate
php artisan serve
```

**API:** http://127.0.0.1:8000/api

**Swagger:** http://127.0.0.1:8000/api/documentation

## API

| Метод | Endpoint | Описание |
|---|---|---|
| GET | `/api/authors` | Список и поиск авторов |
| GET | `/api/authors/{id}` | Автор по ID |
| GET | `/api/authors/slug/{slug}` | Автор по slug |
| GET | `/api/categories` | Список категорий |
| GET | `/api/categories/tree` | Дерево категорий |
| GET | `/api/categories/{id}` | Категория по ID |
| GET | `/api/categories/slug/{slug}` | Категория по slug |
| GET | `/api/articles` | Список и поиск статей |
| GET | `/api/articles/{id}` | Статья по ID |
| GET | `/api/articles/slug/{slug}` | Статья по slug |

Поддерживаются фильтрация, поиск, пагинация и сортировка.

Пример:

```http
GET /api/articles?q=Laravel&author_id=5&per_page=10
```

## Тестирование

```bash
php artisan test
```

Проверка стиля кода:

```bash
./vendor/bin/pint --test
```

## Особенности

- Генерация 10 000 статей через Factories и Seeders.
- Вложенные категории через Nested Set.
- Автоматическая генерация уникальных slug.
- Связи One-to-Many и Many-to-Many.
- JSON API Resources и Swagger-документация.
- Feature-тесты основных API.
