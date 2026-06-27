<?php
namespace Tests\DataProvider;

class RouterDataProvider
{
    public static function routeNotFoundCases(): array
    {
        return [
            ['/User', 'put'],
            ['/invoices', 'post'],
            ['/User', 'get'],
            ['/User', 'post']
        ];
    }
}