<?php

namespace App\OpenApi\Endpoints;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/authors',
    summary: 'Список авторов',
    tags: ['Authors'],
    parameters: [
        new OA\Parameter(
            name: 'last_name',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'string')
        ),
        new OA\Parameter(
            name: 'page',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 1)
        ),
        new OA\Parameter(
            name: 'per_page',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 20)
        ),
        new OA\Parameter(
            name: 'sort_by',
            in: 'query',
            required: false,
            schema: new OA\Schema(
                type: 'string',
                enum: ['id', 'full_name', 'birth_year']
            )
        ),
        new OA\Parameter(
            name: 'sort_dir',
            in: 'query',
            required: false,
            schema: new OA\Schema(
                type: 'string',
                enum: ['asc', 'desc']
            )
        ),
    ],
    responses: [
        new OA\Response(response: 200, description: 'Список авторов'),
        new OA\Response(response: 422, description: 'Ошибка валидации'),
    ]
)]

#[OA\Get(
    path: '/api/authors/slug/{slug}',
    summary: 'Получить автора по slug',
    tags: ['Authors'],
    parameters: [
        new OA\Parameter(
            name: 'slug',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string')
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Данные автора'),
        new OA\Response(response: 404, description: 'Автор не найден'),
    ]
)]

#[OA\Get(
    path: '/api/authors/{author}',
    summary: 'Получить автора по ID',
    tags: ['Authors'],
    parameters: [
        new OA\Parameter(
            name: 'author',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Данные автора'),
        new OA\Response(response: 404, description: 'Автор не найден'),
    ]
)]


class AuthorEndpoints {}
