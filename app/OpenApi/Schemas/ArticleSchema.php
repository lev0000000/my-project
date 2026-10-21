<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Article',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'title', type: 'string'),
        new OA\Property(property: 'image', type: 'string'),
        new OA\Property(property: 'excerpt', type: 'string'),
        new OA\Property(property: 'content', type: 'string'),
        new OA\Property(property: 'author_id', type: 'integer'),
        new OA\Property(property: 'slug', type: 'string', nullable: true),
    ]
)]
class ArticleSchema {}