<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Articles REST API',
    description: 'API для авторов, статей и категорий'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Локальный сервер'
)]
class OpenApiSpec
{
}
