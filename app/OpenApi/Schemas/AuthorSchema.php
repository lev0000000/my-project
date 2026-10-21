<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Author',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'full_name', type: 'string'),
        new OA\Property(property: 'last_name', type: 'string'),
        new OA\Property(property: 'slug', type: 'string'),
        new OA\Property(property: 'birth_year', type: 'integer'),
        new OA\Property(property: 'biography', type: 'string'),
        new OA\Property(property: 'avatar', type: 'string', nullable: true),
    ]
)]
class AuthorSchema {}