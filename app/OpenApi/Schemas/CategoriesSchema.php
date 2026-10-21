<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Categories',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'title', type: 'string'),
        new OA\Property(property: 'image', type: 'string'),
        new OA\Property(property: 'slug', type: 'string'),
        new OA\Property(property: 'parent_id', type: 'integer')
    ]
)]
class CategoriesSchema {}