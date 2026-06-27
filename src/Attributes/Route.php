<?php
namespace App\Attributes;

use App\Enums\HttpMethod;
use Attribute;
// puttting restriction ob attribute where to use
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route
{
    public function __construct(public string $path, public HttpMethod $method = HttpMethod::Get)
    {

    }

}