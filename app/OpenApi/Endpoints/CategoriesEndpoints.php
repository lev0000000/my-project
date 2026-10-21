<?php

namespace App\OpenApi\Endpoints;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/categories',
    summary: 'Список категорий',
    tags: ['Categories'],
    parameters: [
        new OA\Parameter(
            name: 'per_page',
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
    path: '/api/categories/tree',
    summary: 'Получить дерево категорий',
    tags: ['Categories'],
    responses: [
        new OA\Response(response: 200, description: 'Данные дерева категорий'),
        new OA\Response(response: 404, description: 'дерево категорий не найдено'),
    ]
)]

#[OA\Get(
    path: '/api/categories/slug/{slug}',
    summary: 'Получить категорию по slug',
    tags: ['Categories'],
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
    path: '/api/categories/{category}',
    summary: 'Получить категорию по id',
    tags: ['Categories'],
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



class CategoriesEndpoints {}
