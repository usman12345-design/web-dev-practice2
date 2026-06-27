<?php
namespace App\Attributes;
use App\Enums\HttpMethod;
use Attribute;
#[Attribute]
class post extends Route
{
    public function __construct(public string $path)
    {
        parent::__construct($path, HttpMethod::Post);
    }

}