<?php
namespace App\Attributes;
use App\Enums\HttpMethod;
use Attribute;
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class get extends Route
{
    public function __construct(public string $path)
    {
        parent::__construct($path, HttpMethod::Get);
    }

}