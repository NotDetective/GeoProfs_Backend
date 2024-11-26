<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'API documentation for GeoProfs backend.',
    title: 'GeoProfs API'
)]
class OpenApiConfig {}

abstract class Controller
{
    //
}
