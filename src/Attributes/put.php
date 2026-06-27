<?php
namespace App\Attributes;
use App\Enums\HttpMethod;
use Attribute;
#[Attribute]
class put extends Route
{
    public function __construct(public string $path)
    {
        parent::__construct($path, HttpMethod::Put);
    }

}