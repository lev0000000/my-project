<?php

namespace App\OpenApi\Endpoints;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/articles',
    summary: 'Список постов',
    tags: ['Article'],
    parameters: [
        new OA\Parameter(
            name: 'q',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 20)
        ),
        new OA\Parameter(
            name: 'author_id',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 20)
        ),
        new OA\Parameter(
            name: 'category_id',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 20)
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
            schema: new OA\Schema(type: 'integer', default: 20)
        ),
        new OA\Parameter(
            name: 'sort_dir',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 20)
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Список категорий'),
        new OA\Response(response: 422, description: 'Ошибка валидации'),
    ]
)]

#[OA\Get(
    path: '/api/articles/slug/{slug}',
    summary: 'Получить Пост по slug',
    tags: ['Article'],
    parameters: [
        new OA\Parameter(
            name: 'slug',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string')
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Данные категории по slug'),
        new OA\Response(response: 404, description: 'категорию по slug не найдено'),
    ]
)]

#[OA\Get(
    path: '/api/articles/{article}',
    summary: 'Получить категорию по id',
    tags: ['Article'],
    parameters: [
        new OA\Parameter(
            name: 'category',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Данные категории по категорию'),
        new OA\Response(response: 404, description: 'категорию по категории не найдено'),
    ]
)]



class ArticleEndpoints {}
