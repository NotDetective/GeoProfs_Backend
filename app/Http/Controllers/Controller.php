<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

define('API_HOST', env('APP_URL'));
#[OA\Info(
    version: '1.0.0',
    description: 'API documentation for GeoProfs backend.',
    title: 'GeoProfs API'
)]
#[OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer')]
/**
 * @OA\Server(url=API_HOST)
 */
class OpenApiConfig
{
}

abstract class Controller
{
    //
}
